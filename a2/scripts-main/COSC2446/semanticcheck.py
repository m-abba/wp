import requests
from requests.auth import HTTPBasicAuth
import os
import sys
import argparse

"""
This script checks for the presence of specific HTML elements in the provided web pages.
It reads base URLs and file names from provided files or uses default values, fetches HTML content, 
and checks for the presence of header, nav, foot, and main elements. The results are saved in HTML format 
in the 'element_check_results' directory.

Usage Instructions:
1. Prepare the Environment:
   - Ensure you have Python installed on your system.
   - Install necessary Python packages by running:
     pip install requests

2. Organize Your Files:
   - Place this script in a directory.
   - In the same directory, create 'base_urls.txt' and 'file_names.txt' if you want to use custom base URLs and file names. 
     Each line in these files should contain one URL or file name.

3. Run the Script:
   - Open a terminal and navigate to the directory containing the script.
   - Run the script using Python with optional arguments for username, password, base URLs file, and file names file:
     python element_check.py -u <username> -p <password> -b <base_urls_file> -f <file_names_file>
   - If you don't provide arguments, default values will be used.

4. View the Results:
   - The script will generate HTML files in the 'element_check_results' directory, containing the element check results for each student's URLs.
"""


# Function to read from file
def read_from_file(file_path):
    try:
        with open(file_path, "r") as file:
            content = [line.strip() for line in file.readlines()]
            return content
    except FileNotFoundError:
        print(f"File not found: {file_path}")
        return []


# Set up argument parsing
parser = argparse.ArgumentParser(
    description="Check for specific HTML elements in web pages."
)
parser.add_argument(
    "-u", "--username", type=str, help="Username for authentication", required=False
)
parser.add_argument(
    "-p", "--password", type=str, help="Password for authentication", required=False
)
parser.add_argument(
    "-b", "--base_urls", type=str, help="File containing base URLs", required=False
)
parser.add_argument(
    "-f", "--file_names", type=str, help="File containing file names", required=False
)

args = parser.parse_args()

# Default credentials, base URLs, and file names
default_username = ""
default_password = ""
script_dir = os.path.dirname(os.path.abspath(__file__))
default_base_urls_file = os.path.join(script_dir, "base_urls.txt")
default_file_names_file = os.path.join(script_dir, "file_names.txt")
default_base_urls = [
    "https://titan.csit.rmit.edu.au/~s3492003/",
    # Add more student base URLs
]
default_file_names = [
    "index.php",
    "add.php",
    "gallery.php",
    "delete_confirm.php",
    "delete.php",
    "edit.php",
    "login.php",
    "details.php",
    "hikes.php",
    "register.php",
    "search.php",
    "user.php",
    # Add more file names as needed
]

# Determine username and password
username = args.username if args.username else default_username
password = args.password if args.password else default_password

# Determine base URLs and file names
base_urls_file = (
    os.path.join(script_dir, args.base_urls)
    if args.base_urls
    else default_base_urls_file
)
file_names_file = (
    os.path.join(script_dir, args.file_names)
    if args.file_names
    else default_file_names_file
)

# Check if files exist and read content
if os.path.isfile(base_urls_file):
    base_urls = read_from_file(base_urls_file)
else:
    print(f"Base URLs file not found: {base_urls_file}. Using default base URLs.")
    base_urls = default_base_urls

if os.path.isfile(file_names_file):
    file_names = read_from_file(file_names_file)
else:
    print(f"File names file not found: {file_names_file}. Using default file names.")
    file_names = default_file_names


# Function to check for the presence of specific HTML elements
def check_html_elements(html_content):
    elements = ["<header", "<nav", "<foot", "<main"]
    results = {element: (element in html_content) for element in elements}
    return results


# Directory to save element check results
output_dir = os.path.join(
    os.path.dirname(os.path.abspath(__file__)), "element_check_results"
)
if not os.path.exists(output_dir):
    os.makedirs(output_dir)


# Function to remove file names from base URL if present
def remove_file_name(url, file_names):
    for file_name in file_names:
        if url.endswith(file_name):
            return url[: -len(file_name)]
    return url


# Iterate over each student's base URL and check each page for HTML elements
for base_url in base_urls:
    base_url = remove_file_name(
        base_url, file_names
    )  # Remove file names from base URL if present
    student_name = base_url.split("~")[1].split("/")[0]  # Extract student name from URL
    html_output = f"""<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Element Check Results</title>
    <style>
        body {{
            font-family: Arial, sans-serif;
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            margin-top: 20px;
        }}
        h1 {{
            text-align: center;
            color: #333;
        }}
        .present {{
            color: green;
        }}
        .missing {{
            color: red;
        }}
    </style>
</head>
<body>
    <h1>Element Check Results for {base_url}</h1>"""

    for file_name in file_names:
        page_url = f"{base_url}{file_name}"
        # print(f"Checking elements in {page_url}")  # Debugging

        try:
            # Fetch the HTML content with POST request
            response = requests.post(page_url, auth=HTTPBasicAuth(username, password))

            if response.status_code == 200:
                html_content = response.text
                element_results = check_html_elements(html_content)

                # Process and report element check results
                html_output += f"<h3>{page_url}</h3>"
                for element, present in element_results.items():
                    element_escaped = element.replace("<", "&lt;")  # Escape HTML tags
                    if present:
                        html_output += (
                            f"<p class='present'>{element_escaped} is present.</p>"
                        )
                    else:
                        html_output += (
                            f"<p class='missing'>{element_escaped} is missing.</p>"
                        )
            else:
                html_output += (
                    f"<p>Failed to access {page_url} (HTTP {response.status_code})</p>"
                )
        except requests.exceptions.RequestException as e:
            html_output += f"<p>Failed to access {page_url}: {e}</p>"

    html_output += "</body></html>"

    # Write the HTML output to a file in the element_check_results directory
    output_file = os.path.join(output_dir, f"{student_name}_element_check_results.html")
    with open(output_file, "w") as file:
        file.write(html_output)

    print(f"Element check results saved for {student_name} to {output_file}")

print("All element check results fetched and saved.")

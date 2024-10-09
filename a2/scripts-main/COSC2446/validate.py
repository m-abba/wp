import requests
from requests.auth import HTTPBasicAuth
import os
import sys
import argparse

"""
This script validates HTML files using the W3C Validator. It reads base URLs and file names from provided files or uses default values, 
fetches HTML content, and validates it using the W3C Validator API. The results are saved in HTML format in the 'validation_results' directory.

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
     python validate.py -u <username> -p <password> -b <base_urls_file> -f <file_names_file>
   - If you don't provide arguments, default values will be used.

4. View the Results:
   - The script will generate HTML files in the 'validation_results' directory, containing the validation results for each student's URLs.
"""


# Function to read from file
def read_from_file(file_path):
    try:
        with open(file_path, "r") as file:
            # print(f"Reading from file: {file_path}")  # Debugging
            content = [line.strip() for line in file.readlines()]
            # print(f"Content of {file_path}: {content}")  # Debugging
            return content
    except FileNotFoundError:
        print(f"File not found: {file_path}")
        return []


# Set up argument parsing
parser = argparse.ArgumentParser(
    description="Validate HTML files using the W3C Validator."
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

# Print file paths for debugging
# print(f"Base URLs file path: {base_urls_file}")
# print(f"File names file path: {file_names_file}")

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

# print(f"Using base URLs: {base_urls}")  # Debugging
# print(f"Using file names: {file_names}")  # Debugging


# Function to validate HTML using v.Nu API
def validate_html(url, html_content):
    headers = {"Content-Type": "text/html; charset=utf-8"}
    response = requests.post(
        "https://validator.w3.org/nu/?out=json",
        headers=headers,
        data=html_content.encode("utf-8"),
    )
    return response.json()


# Directory to save validation results
output_dir = os.path.join(
    os.path.dirname(os.path.abspath(__file__)), "validation_results"
)
if not os.path.exists(output_dir):
    os.makedirs(output_dir)


# Function to remove file names from base URL if present
def remove_file_name(url, file_names):
    for file_name in file_names:
        if url.endswith(file_name):
            return url[: -len(file_name)]
    return url


# Iterate over each student's base URL and validate each page
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
    <title>Validation results</title>
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
        .error {{
            color: red;
        }}
        .success {{
            color: green;
        }}
    </style>
</head>
<body>
    <h1>Validation results for {base_url}</h1>"""

    for file_name in file_names:
        page_url = f"{base_url}{file_name}"
        # print(f"Validating {page_url}")  # Debugging

        try:
            # Fetch the HTML content with POST request
            response = requests.post(page_url, auth=HTTPBasicAuth(username, password))

            if response.status_code == 200:
                html_content = response.text
                validation_results = validate_html(page_url, html_content)

                # Process and report validation results, filtering out info and warning messages
                html_output += f"<h3>{page_url}</h3>"
                error_found = False
                for message in validation_results["messages"]:
                    if message["type"] == "error":
                        error_found = True
                        html_output += f"<p class='error'>{message['type']}: {message['message']}</p>"
                if not error_found:
                    html_output += "<p class='success'>No errors found.</p>"
            else:
                html_output += (
                    f"<p>Failed to access {page_url} (HTTP {response.status_code})</p>"
                )
        except requests.exceptions.RequestException as e:
            html_output += f"<p>Failed to access {page_url}: {e}</p>"

    html_output += "</body></html>"

    # Write the HTML output to a file in the validation_results directory
    output_file = os.path.join(output_dir, f"{student_name}_validation_results.html")
    with open(output_file, "w") as file:
        file.write(html_output)

    print(f"Validation results saved for {student_name} to {output_file}")

print("All validation results fetched and saved.")

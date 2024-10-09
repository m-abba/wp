import os
import sys
import zipfile
import rarfile
import re

"""
This script processes zip and rar files in the 'submissions' directory, extracts README.md files, 
and searches for URLs within those files. It outputs found URLs to 'base_urls.txt' and logs directories 
with no found URLs to 'no_links.txt'.

Usage Instructions:
1. Prepare the Environment:
   - Ensure you have 'unrar' installed on your system.
   - Install necessary Python packages by running:
     pip install rarfile

2. Organize Your Files:
   - Download 'submissions.zip' freom Canvas into the same directory as this script.
   - Extract 'submissions.zip' to create the 'submissions' directory.
   - All the zip and rar files of student submissions will be in the 'submissions' directory.

3. Run the Script:
   - Open a terminal and navigate to the directory containing the script.
   - Run the script using Python:
     python links.py

4. View the Results:
   - The script will generate two files:
     - 'base_urls.txt': Contains the extracted URLs from the README.md files.
     - 'no_links.txt': Contains the names of directories where no README.md file was found.
"""

# Ensure rarfile uses the correct unrar executable
rarfile.UNRAR_TOOL = "/usr/local/bin/unrar"

# Get the directory of the current script
script_dir = os.path.dirname(os.path.abspath(__file__))

# Define the directories
submissions_dir = os.path.join(script_dir, "submissions")
output_file = os.path.join(script_dir, "base_urls.txt")
no_links_file = os.path.join(script_dir, "no_links.txt")


# Function to extract the link from README.md
def extract_link(readme_path):
    with open(readme_path, "r") as file:
        content = file.read()
        match = re.search(
            r"(http[s]?://(?:titan|jupiter|saturn)\.csit\.rmit\.edu\.au/~s\d+[^ \n]*)",
            content,
        )
        if match:
            return match.group(1)
        else:
            return None


# Create or clear the output files
with open(output_file, "w") as file:
    pass

with open(no_links_file, "w") as file:
    pass

# Process each zip or rar file in the submissions directory
for filename in os.listdir(submissions_dir):
    if filename.endswith(".zip") or filename.endswith(".rar"):
        # Define paths
        file_path = os.path.join(submissions_dir, filename)
        extract_dir = os.path.join(submissions_dir, os.path.splitext(filename)[0])

        try:
            # Unzip or Unrar the file
            if filename.endswith(".zip"):
                with zipfile.ZipFile(file_path, "r") as zip_ref:
                    zip_ref.extractall(extract_dir)
            elif filename.endswith(".rar"):
                with rarfile.RarFile(file_path, "r") as rar_ref:
                    rar_ref.extractall(extract_dir)

            # Search for README.md
            readme_found = False
            for root, dirs, files in os.walk(extract_dir):
                if "README.md" in files:
                    readme_path = os.path.join(root, "README.md")
                    link = extract_link(readme_path)
                    if link:
                        with open(output_file, "a") as file:
                            file.write(f"{link}\n")
                    else:
                        with open(no_links_file, "a") as file:
                            file.write(f"{os.path.basename(extract_dir)}\n")
                    readme_found = True
                    break

            if not readme_found:
                with open(no_links_file, "a") as file:
                    file.write(f"{os.path.basename(extract_dir)}\n")

        except (zipfile.BadZipFile, rarfile.BadRarFile) as e:
            print(f"Error: {filename} is not a valid zip or rar file.")
            with open(no_links_file, "a") as file:
                file.write(
                    f"{os.path.basename(extract_dir)} (invalid zip or rar file)\n"
                )

print("Processing complete. Check base_urls.txt and no_links.txt for results.")

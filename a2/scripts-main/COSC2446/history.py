import requests
import os
import sys
import argparse

"""
This script fetches the commit history for a list of GitHub repositories using the GitHub API and saves the history to text files.

Usage Instructions:
1. Prepare the Environment:
   - Ensure you have Python installed on your system.
   - Install necessary Python packages by running:
     pip install requests

2. Obtain a GitHub Personal Access Token:
   - Generate a GitHub token from your GitHub account settings with the necessary permissions.

3. Organize Your Files:
   - Place this script in a directory.
   - Create a file named 'repositories.txt' in the same directory, listing each repository in the format 'username/repo' on a new line.
   - Optionally, you can set the GitHub token in a file named 'token.txt'.

4. Run the Script:
   - Open a terminal and navigate to the directory containing the script.
   - Run the script using Python with optional arguments for GitHub token and repositories file:
     python history.py -t <github_token> -f <repositories_file>
   - If you don't provide arguments, default values will be used.

5. View the Results:
   - The script will generate text files in the 'commit_histories' directory, containing the commit history for each repository.
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
    description="Fetch and save commit history for GitHub repositories."
)
parser.add_argument(
    "-t", "--token", type=str, help="GitHub Personal Access Token", required=False
)
parser.add_argument(
    "-f",
    "--repositories",
    type=str,
    help="File containing list of repositories",
    required=False,
)

args = parser.parse_args()

# Default GitHub token and repositories
default_token = ""
script_dir = os.path.dirname(os.path.abspath(__file__))
default_repositories_file = os.path.join(script_dir, "repositories.txt")
default_repositories = [
    "s4009723/wp",
    "s4036533/wp",
    # Add more repositories as needed
]

# Determine GitHub token
token_file = os.path.join(script_dir, "token.txt")
if args.token:
    GITHUB_TOKEN = args.token
elif os.path.isfile(token_file):
    GITHUB_TOKEN = read_from_file(token_file)[0]  # Read token from file
else:
    GITHUB_TOKEN = default_token

# Determine repositories
repositories_file = (
    os.path.join(script_dir, args.repositories)
    if args.repositories
    else default_repositories_file
)

# Check if repositories file exists and read content
if os.path.isfile(repositories_file):
    repositories = read_from_file(repositories_file)
else:
    print(
        f"Repositories file not found: {repositories_file}. Using default repositories."
    )
    repositories = default_repositories

# Append '/wp' to each repository if not already present and add 's' if not present
repositories = [repo if repo.startswith("s") else f"s{repo}" for repo in repositories]
repositories = [repo if repo.endswith("/wp") else f"{repo}/wp" for repo in repositories]

# GitHub API URL
GITHUB_API_URL = "https://api.github.com/repos"

# Headers for authentication
headers = {"Authorization": f"token {GITHUB_TOKEN}"}

# Directory to save commit history
output_dir = os.path.join(
    os.path.dirname(os.path.abspath(__file__)), "commit_histories"
)
if not os.path.exists(output_dir):
    os.makedirs(output_dir)


# Function to fetch commit history for a repository
def fetch_commit_history(repo):
    url = f"{GITHUB_API_URL}/{repo}/commits"
    response = requests.get(url, headers=headers)

    if response.status_code == 200:
        commits = response.json()
        return commits
    else:
        print(f"Failed to fetch commit history for {repo}")
        return []


# Function to save commit history to a file
def save_commit_history(repo, commits):
    repo_name = repo.replace("/", "_")
    file_path = os.path.join(output_dir, f"{repo_name}_commits.txt")

    with open(file_path, "w") as file:
        for commit in commits:
            commit_message = commit["commit"]["message"]
            commit_author = commit["commit"]["author"]["name"]
            commit_date = commit["commit"]["author"]["date"]
            file.write(
                f"Author: {commit_author}\nDate: {commit_date}\nMessage: {commit_message}\n\n"
            )

    print(f"Commit history saved for {repo} to {file_path}")


# Fetch and save commit history for each repository
for repo in repositories:
    commits = fetch_commit_history(repo)
    if commits:
        save_commit_history(repo, commits)

print("All commit histories fetched and saved.")

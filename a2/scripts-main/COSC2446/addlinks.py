import re


# Function to extract student IDs from a list of URLs
def extract_student_ids(urls):
    student_ids = set()
    pattern = re.compile(r"~s\d+")
    for url in urls:
        match = pattern.search(url)
        if match:
            student_ids.add(match.group(0))
    return student_ids


# Function to read URLs from a file
def read_urls(file_path):
    with open(file_path, "r") as file:
        return [line.strip() for line in file.readlines()]


# Function to write URLs to a file
def write_urls(file_path, urls):
    with open(file_path, "w") as file:
        for url in urls:
            file.write(url + "\n")


# Read URLs from both files
file1_path = "base_urls.txt"
file2_path = "base_urls2.txt"
urls_file1 = read_urls(file1_path)
urls_file2 = read_urls(file2_path)

# Extract student IDs from both sets of URLs
student_ids_file1 = extract_student_ids(urls_file1)
student_ids_file2 = extract_student_ids(urls_file2)

# Find new URLs to add to file1
new_urls = [
    url
    for url in urls_file2
    if re.search(r"~s\d+", url).group(0) not in student_ids_file1
]

# Add new URLs to file1
urls_file1.extend(new_urls)

# Write the updated list of URLs back to file1
write_urls(file1_path, urls_file1)

print(f"Added {len(new_urls)} new URLs to {file1_path}")

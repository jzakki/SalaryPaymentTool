import openai
import os
import subprocess
import requests

# Set your OpenAI API key
openai.api_key = os.getenv("OPENAI_API_KEY")

# GitHub repository details
GITHUB_TOKEN = os.getenv("GIT_TOKEN")
REPO = os.getenv("GITHUB_REPOSITORY")
PR_NUMBER = os.getenv("PR_NUMBER")

# Print debug information for local testing
print(f"GITHUB_TOKEN: {'Set' if GITHUB_TOKEN else 'Not Set'}")
print(f"REPO: {REPO}")
print(f"PR_NUMBER: {PR_NUMBER}")

def get_changed_files():
    """
    Fetches the list of changed files in the pull request.
    """
    try:
        result = subprocess.run(["git", "diff", "--name-only", "HEAD~1"], capture_output=True, text=True)
        return result.stdout.strip().split("\n")
    except Exception as e:
        print(f"Error fetching changed files: {e}")
        return []

def get_file_diff(file_path):
    """
    Fetches the diff of a specific file.
    """
    try:
        result = subprocess.run(["git", "diff", file_path], capture_output=True, text=True)
        return result.stdout
    except Exception as e:
        print(f"Error fetching file diff for {file_path}: {e}")
        return ""

def analyze_code_with_ai(file_diff):
    """
    Sends the file diff to OpenAI for analysis and feedback.
    """
    prompt = f"""
    You are an expert code reviewer. Analyze the following code changes and provide constructive feedback:
    {file_diff}
    """
    try:
        response = openai.ChatCompletion.create(
            model="gpt-3.5-turbo",  # Updated model
            messages=[
                {"role": "system", "content": "You are a helpful assistant and expert code reviewer."},
                {"role": "user", "content": prompt},
            ],
            max_tokens=500,
        )
        return response["choices"][0]["message"]["content"].strip()
    except Exception as e:
        print(f"Error analyzing code with AI: {e}")
        return "Error analyzing code with AI."

def post_comment_to_pr(feedback, file_name):
    """
    Posts feedback as a comment on the pull request using the GitHub API.
    """
    url = f"https://api.github.com/repos/{REPO}/issues/{PR_NUMBER}/comments"
    headers = {"Authorization": f"Bearer {GITHUB_TOKEN}"}
    data = {"body": f"### Feedback for `{file_name}`\n\n{feedback}"}

    try:
        response = requests.post(url, json=data, headers=headers)
        if response.status_code == 201:
            print(f"Feedback for {file_name} posted successfully.")
        else:
            print(f"Failed to post feedback for {file_name}: {response.status_code} {response.content}")
    except Exception as e:
        print(f"Error posting feedback to PR: {e}")

def main():
    # Get the list of changed files
    changed_files = get_changed_files()

    if not changed_files:
        print("No changed files detected.")
        return

    # Iterate over each file and analyze the changes
    for file in changed_files:
        # Get the diff of the file
        file_diff = get_file_diff(file)

        if not file_diff.strip():
            continue  # Skip files with no changes

        # Analyze the code with AI
        feedback = analyze_code_with_ai(file_diff)

        # Post feedback as a comment to the pull request
        post_comment_to_pr(feedback, file)

if __name__ == "__main__":
    main()

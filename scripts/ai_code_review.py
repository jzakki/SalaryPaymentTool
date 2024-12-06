import openai
import os
import subprocess

# Set your OpenAI API key
openai.api_key = os.getenv("OPENAI_API_KEY")

def get_changed_files():
    """
    Fetches the list of changed files in the pull request.
    """
    result = subprocess.run(["git", "diff", "--name-only", "HEAD~1"], capture_output=True, text=True)
    return result.stdout.strip().split("\n")

def get_file_diff(file_path):
    """
    Fetches the diff of a specific file.
    """
    result = subprocess.run(["git", "diff", file_path], capture_output=True, text=True)
    return result.stdout

def analyze_code_with_ai(file_diff):
    """
    Sends the file diff to OpenAI for analysis and feedback.
    """
    prompt = f"""
    You are an expert code reviewer. Analyze the following code changes and provide constructive feedback:
    {file_diff}
    """
    response = openai.Completion.create(
        engine="text-davinci-003",
        prompt=prompt,
        max_tokens=500
    )
    return response.choices[0].text.strip()

def main():
    # Get the list of changed files
    changed_files = get_changed_files()

    if not changed_files:
        print("No changed files detected.")
        return

    print(f"Changed files: {changed_files}")

    # Iterate over each file and analyze the changes
    for file in changed_files:
        print(f"\nAnalyzing file: {file}")

        # Get the diff of the file
        file_diff = get_file_diff(file)

        if not file_diff.strip():
            print(f"No changes detected in file: {file}")
            continue

        # Analyze the code with AI
        feedback = analyze_code_with_ai(file_diff)

        # Output feedback
        print(f"\nFeedback for {file}:\n{feedback}\n")
        # Save feedback to a file
        with open(f"{file}_feedback.txt", "w") as f:
            f.write(f"Feedback for {file}:\n{feedback}\n")

if __name__ == "__main__":
    main()

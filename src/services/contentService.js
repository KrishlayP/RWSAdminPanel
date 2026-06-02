const API_URL = process.env.EXPO_PUBLIC_API_URL;

export async function fetchRemoteContent() {
  if (!API_URL) {
    return null;
  }

  const response = await fetch(`${API_URL.replace(/\/$/, "")}/api/content`);

  if (!response.ok) {
    throw new Error("Content API request failed.");
  }

  return response.json();
}

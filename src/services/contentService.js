const API_URL = process.env.EXPO_PUBLIC_API_URL;
const CONTENT_REQUEST_TIMEOUT_MS = 5000;

export async function fetchRemoteContent() {
  if (!API_URL) {
    return null;
  }

  const controller = new AbortController();
  const timeout = setTimeout(() => controller.abort(), CONTENT_REQUEST_TIMEOUT_MS);

  try {
    const response = await fetch(
      `${API_URL.replace(/\/$/, "")}/api/content?t=${Date.now()}`,
      {
        cache: "no-store",
        headers: {
          "Cache-Control": "no-cache",
        },
        signal: controller.signal,
      },
    );

    if (!response.ok) {
      throw new Error("Content API request failed.");
    }

    return response.json();
  } catch {
    return null;
  } finally {
    clearTimeout(timeout);
  }
}

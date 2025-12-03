type LoginPayload = {
  email: string;
  password: string;
};

type RegisterPayload = {
  name: string;
  email: string;
  phone: string;
  password: string;
  company_name: string;
  role?: string;
};

export type UpdateProfilePayload = {
  company_name?: string;
  phone?: string;
  address?: string;
  province?: string;
  city?: string;
  timezone?: string;
};

export type AuthResponse = {
  token: string;
  user?: {
    id: number;
    name: string;
    email: string;
    role?: string;
    is_owner?: boolean;
    company_name?: string;
  };
  role?: string;
  is_owner?: boolean;
  company_name?: string;
  [key: string]: unknown;
};

// const API_URL = process.env.EXPO_PUBLIC_API_URL ?? 'http://192.168.1.2:8000/api';
const API_URL = 'http://148.230.99.135:8040/api';

async function postJson(
  endpoint: string,
  payload: unknown,
  fallbackMessage: string,
): Promise<AuthResponse> {
  const response = await fetch(`${API_URL}${endpoint}`, {
    method: 'POST',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(payload),
  });

  const data = await response.json().catch(() => ({}));

  if (!response.ok) {
    const message = (data && (data.message as string)) ?? fallbackMessage;
    throw new Error(message);
  }

  return data as AuthResponse;
}

/**
 * Attempts to sign in against the Laravel backend. Throws if invalid credentials or network issues.
 */
export async function login(payload: LoginPayload): Promise<AuthResponse> {
  return postJson('/login', payload, 'Tidak dapat masuk. Periksa koneksi atau kredensial Anda.');
}

/**
 * Creates a new account on the Laravel backend and returns the auth payload.
 */
export async function register(payload: RegisterPayload): Promise<AuthResponse> {
  return postJson(
    '/register',
    payload,
    'Tidak dapat mendaftar. Periksa data yang Anda masukkan lalu coba lagi.',
  );
}

export async function logout(token: string) {
  const response = await fetch(`${API_URL}/logout`, {
    method: 'POST',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`,
    },
  });

  if (!response.ok) {
    const data = await response.json().catch(() => ({}));
    const message = (data && (data.message as string)) ?? 'Logout gagal di server.';
    throw new Error(message);
  }
}

export async function updateProfile(
  token: string,
  payload: UpdateProfilePayload,
): Promise<AuthResponse> {
  const response = await fetch(`${API_URL}/profile`, {
    method: 'PUT',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify(payload),
  });

  const data = await response.json().catch(() => ({}));
  if (!response.ok) {
    const message = (data && (data.message as string)) ?? 'Profil gagal diperbarui.';
    throw new Error(message);
  }
  return data as AuthResponse;
}

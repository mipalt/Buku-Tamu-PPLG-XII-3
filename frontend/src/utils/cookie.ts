import Cookies from "js-cookie";

const TOKEN_KEY = "auth_token";

export const setAuthToken = (token: string, days = 1) => {
  Cookies.set(TOKEN_KEY, token, {
    expires: days,
    // secure: true,
    sameSite: "strict",
  });
};

export const getAuthToken = (): string | undefined => {
  return Cookies.get(TOKEN_KEY);
};

export const removeAuthToken = () => {
  Cookies.remove(TOKEN_KEY);
};

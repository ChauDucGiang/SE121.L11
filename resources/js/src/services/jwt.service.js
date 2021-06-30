const ID_TOKEN_KEY = "user_token";
const ID_TOKEN_CURRENT_USER = "user_info";

export const getToken = () => {
  return window.localStorage.getItem(ID_TOKEN_KEY);
};

export const getCurrentUser = () => {
  const user = window.localStorage.getItem(ID_TOKEN_CURRENT_USER);

  if (!user) {
    return null;
  }

  return JSON.parse(user);
};


export const saveCurrentUser = info => {
  window.localStorage.setItem(ID_TOKEN_CURRENT_USER, info);
};

export const saveToken = token => {
  window.localStorage.setItem(ID_TOKEN_KEY, token);
};

export const destroyToken = () => {
  window.localStorage.removeItem(ID_TOKEN_KEY);
  window.localStorage.removeItem(ID_TOKEN_CURRENT_USER);
};

export default {getToken, saveToken, destroyToken, saveCurrentUser, getCurrentUser};

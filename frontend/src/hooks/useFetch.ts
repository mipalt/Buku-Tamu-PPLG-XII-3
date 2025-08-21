// import useSWR from "swr";

// const fetcher = async (url: string) => {
//   const res = await fetch(url);
//   if (!res.ok) throw new Error("Error fetching data");
//   return res.json();
// };

// export function useFetch<T>(url: string) {
//   const { data, error, isLoading, mutate } = useSWR<T>(url, fetcher);

//   return { data, error, isLoading, mutate };
// }

import useSWR from "swr";

const fetcher = async (url: string, token?: string) => {
  const res = await fetch(url, {
    headers: {
      Authorization: token ? `Bearer ${token}` : "",
    },
  });
  if (!res.ok) throw new Error("Error fetching data");
  return res.json();
};

export function useFetch<T>(url: string, token?: string) {
  const { data, error, isLoading, mutate } = useSWR<T>(
    url,
    () => fetcher(url, token)
  );

  return { data, error, isLoading, mutate };
}
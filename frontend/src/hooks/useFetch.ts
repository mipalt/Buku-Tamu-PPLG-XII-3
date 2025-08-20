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

const fetcher = async (url: string) => {
  const res = await fetch(url, {
    headers: {
      'Authorization': 'Bearer 4|EiVBGMZ2JFXyKs2tHLZ7Wq2vfRGqjFJQIOd9OJH116bb1a51',
      'Accept': 'application/json'
    }
  });
  if (!res.ok) throw new Error("Error fetching data");
  return res.json();
};

export function useFetch<T>(url: string) {
  const { data, error, isLoading, mutate } = useSWR<T>(url, fetcher);
  return { data, error, isLoading, mutate };
}
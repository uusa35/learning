import Lang from "lang.js";
import messages from "@/messages.json";
import { first, split } from "lodash";
import { Country } from "@/types/queries";
export const pusherChannel = window.Echo.channel("backend-notification");
// export const baseUrl = `${process.env.NEXT_PUBLIC_BASE_URL}`;
export const baseUrl = import.meta.env.VITE_APP_URL;
export const apiUrl = `${baseUrl}/api/`;
export const appVersion = `0.0.1`;
export const imageUrl = `https://loremflickr.com/`;
export const isLocal = process.env.NODE_ENV !== 'production';
export const suppressText = true;
export const trans = new Lang({
    messages,
    locale: "en",
    fallback: "ar"
});

export const getTrans = (element: string): string => trans.get(`general.${element}`)
export const getCurrentModule = (currentRouteName: string): string => split(currentRouteName, ".", 2)[1] ?? ``
export const getPrice = (element: number, country: Country): string => `${(element * country.exchange_rate).toFixed(2)} ${country.currency_symbol}`;

// export const toEn = (s: string) =>
//     s.replace(/[\u0660-\u0669\u06f0-\u06f9]/g, (a) => a.charCodeAt(0) & 15);

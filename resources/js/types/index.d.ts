import { Config } from 'ziggy-js';
import { ElementPagination } from './queries';

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    ziggy: Config & { location: string };
    currentRouteName: string;
    currentLang: Locale["lang"];
    elements?: ElementPagination<any>;
    element?: any | User;
    categories?: [any]
    setting: Setting;
};

export interface Locale {
    lang: "ar" | "en";
    isRTL: boolean;
    dir: "ltr" | "rtl";
    label: string;
    otherLang: "ar" | "en";
}

export type Setting = {
    id: number;
    name: string;
    description: string;
    aboutus: string;
    services: string;
    address: string;
    country: string;
    [key: string]: any;
}

export type toastMessage = {
    content: string;
    type: string | 'default' | 'success' | 'error' | 'warning' | 'info';
    title?: string;
    showToast: boolean;
}



export type localeType = Locale | string | string[];

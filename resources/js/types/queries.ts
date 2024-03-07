

export type ElementPagination<T> = {
    current_page: string;
    next_page: string;
    per_page: string;
    prev_page: string;
    data: T[];
    total: string;
    meta?: any;
    links?: any;
};

export interface User {
    id: number;
    username: string;
    name: string | any;
    description?: string | any;
    caption?: string | any;
    active: boolean;
    email: string;
    email_verified_at: string;
    roles?: Role;
    deals: Deal;
    isAdmin?: boolean;
    isSuper?: boolean;
    isCompany?: boolean;
    api_token?: string;
    image?: string;
}

export interface TranslationJson {
    ar: string;
    en: string;
    ru: string;
}

export interface Deal {
    id: number;
    membership: Membership;
    [key: string]: any;
}

export interface Membership {
    id: number;
    name: string;
    [key: string]: any;
}

export interface Role {
    [key: string]: any;
    id: number;
    name: string;
}

export type Category = {
    id: number;
    name: string;
    image: string;
    active: boolean;
    [key: string]: any;
};

export type AppQueryResult<T> = {
    data: T;
    links: any;
    meta: any
};

export interface Country {
    [key: string]: any;
    id: number;
    name: TranslationJson | string;
}

export interface Newsletter {
    [key: string]: any;
    id: number;
    email: string;
    active: boolean;
}


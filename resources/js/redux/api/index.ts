import { apiUrl } from '@/constants';
import { RootState } from '@/redux/store';
import { Locale } from '@/types/index';
import { Country } from '@/types/queries';
import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';

export const apiSlice = createApi({
    reducerPath: 'api',
    baseQuery: fetchBaseQuery({
        baseUrl: `${apiUrl}`,
        prepareHeaders: async (
            headers,
            { getState, type, endpoint, extra }: RootState,
        ) => {
            const {
                setting,
                locale: { lang },
            } = getState() as RootState;
            headers.set(
                'Access-Control-Allow-Headers',
                'X-Requested-With,Accept,Authentication,Content-Type',
            );
            headers.set('Accept-Language', lang);
            headers.set(
                'Access-Control-Allow-Methods',
                'GET,PUT,POST,DELETE,PATCH,OPTIONS',
            );
            headers.set('Content-Type', 'application/json');
            headers.set('Accept', 'application/json');
            headers.set('Cache-Control', 'no-store');
            // if (auth.isAuth && auth.user.api_token) {
            //   headers.set("Authorization", `Bearer ${auth.user.api_token}`);
            //   headers.set("api_token", `${auth.user.api_token}`);
            // }
            return headers;
        },
        // credentials: "include",
        credentials: 'same-origin',
    }),
    refetchOnReconnect: true,
    endpoints: (builder) => ({
        getSetting: builder.query<Country[], { lang: Locale['lang'] }>({
            query: () => ({
                url: `setting`,
                validateStatus: (response, result) => response.status == 200,
            }),
        }),
    }),
});

export const { useGetSettingQuery } = apiSlice;

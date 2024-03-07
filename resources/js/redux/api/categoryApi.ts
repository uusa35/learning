import { apiSlice } from './index';
import { AppQueryResult, Category } from '@/types/queries';

export const categoryApi = apiSlice.injectEndpoints({
    endpoints: (builder) => ({
        getCategories: builder.query<
            AppQueryResult<[Category]>,
            void | undefined
        >({
            query: () => ({
                url: `category`,
                validateStatus: (response, result) => response.status == 200,
            }),
        }),
    }),
});

export const { useGetCategoriesQuery, useLazyGetCategoriesQuery } = categoryApi;

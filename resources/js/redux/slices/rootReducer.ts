import { combineReducers } from '@reduxjs/toolkit';
import { localeSlice } from '@/redux/slices/localeSlice';
import { apiSlice } from '@/redux/api';
import { toastMessageSlice } from '@/redux/slices/toastMessageSlice';

export const rootReducer = combineReducers({
    [localeSlice.name]: localeSlice.reducer,
    [toastMessageSlice.name]: toastMessageSlice.reducer,
    [apiSlice.reducerPath]: apiSlice.reducer,
});

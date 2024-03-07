import {createSlice, PayloadAction} from '@reduxjs/toolkit';
import {Country} from '@/types/queries';

const initialState: Country = {
    id: 1,
    name: 'Saudiov',
    currency_symbol: 'SR',
    exchange_rate: 1,
    calling_code: '966',
    country_code: 'KSA',
    active: true,
    is_local: true,
    longitude: '178.970071',
    latitude: ',-20.982252',
    image: 'KSA.png',
    order: 1,
    lang: 'ar',
};

export const countrySlice = createSlice({
    name: 'country',
    initialState,
    reducers: {
        setCountry: (
            state: typeof initialState,
            action: PayloadAction<Country>,
        ) => ({
            ...action.payload,
        }),
    },
});

export const {setCountry} = countrySlice.actions;

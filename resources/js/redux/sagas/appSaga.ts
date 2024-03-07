import {trans} from '@/constants';
import {persistor} from '@/redux/store';
import {Locale} from '@/types/index';
import {PayloadAction} from '@reduxjs/toolkit';
import {startCase} from 'lodash';
import moment from 'moment';
import {toast} from 'react-toastify';
import {call, delay, put, select} from 'redux-saga/effects';
import * as yup from 'yup';
import {toastMessageSlice} from '../slices/toastMessageSlice';

export function* startResetEnireAppSceanrio() {
    persistor.purge();
}

export function* startEnableLoadingScenario(action: PayloadAction) {
    try {
    } catch (e) {
    } finally {
    }
}

export function* startUpdateCartProductScenario(action: PayloadAction<any>) {
    try {
    } catch (e) {
    } finally {
    }
}

export function* startShowToastMessageScenario(action: PayloadAction<any>) {
    try {
        const {toastMessage} = yield select();
        toast(startCase(toastMessage.content), {type: toastMessage.type});
        yield delay(2000);
        yield put({type: `${toastMessageSlice.actions.hideToastMessage}`});
    } catch (e) {
    } finally {
    }
}

export function* startChangeLangScenario(
    action: PayloadAction<Locale['lang']>,
) {
    trans.setLocale(action.payload);

    yield call(moment.locale, action.payload), moment.locale(action.payload);
    yup.setLocale({
        mixed: {
            required: 'validation.required',
        },
        number: {
            min: ({min}) => ({key: 'validation.min', values: {min}}),
            max: ({max}) => ({key: 'validation.max', values: {max}}),
        },
        string: {
            email: 'validation.email',
            min: ({min}) => ({key: `validation.min`, values: min}),
            max: ({max}) => ({key: 'validation.max', values: max}),
            matches: 'validation.matches',
        },
    });
}

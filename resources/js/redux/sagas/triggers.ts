import {
    takeLatest,
    call,
    put,
    all,
    throttle,
    takeEvery,
    debounce,
} from 'redux-saga/effects';
import {
    startChangeLangScenario,
    startEnableLoadingScenario,
    startResetEnireAppSceanrio,
    startShowToastMessageScenario,
    startUpdateCartProductScenario,
} from './appSaga';
import {localeSlice} from '@/redux/slices/localeSlice';
import {toastMessageSlice} from '../slices/toastMessageSlice';

export function* triggerResetEntireApp() {
    yield takeLatest(`resetEntireApp`, startResetEnireAppSceanrio);
}

export function* triggerEnableLoading() {
    // yield takeLatest(
    //   `${appLoadingSlice.actions.enableAppLoading}`,
    //   startEnableLoadingScenario
    // );
}

export function* triggerShowToastMessage() {
    yield takeLatest(
        [
            `${toastMessageSlice.actions.showToastMessage}`,
            `${toastMessageSlice.actions.showSuccessToastMessage}`,
            `${toastMessageSlice.actions.showErrorToastMessage}`,
            `${toastMessageSlice.actions.showWarningToastMessage}`,
        ],
        startShowToastMessageScenario,
    );
}

export function* triggerChangeLang() {
    yield takeLatest(
        `${localeSlice.actions.setLocale}`,
        startChangeLangScenario,
    );
}

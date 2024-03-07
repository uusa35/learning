import { isLocal } from "@/constants";
import { apiSlice } from "@/redux/api";
import { categoryApi } from "@/redux/api/categoryApi";
import rootSaga from "@/redux/sagas/rootSaga";
import { rootReducer } from "@/redux/slices/rootReducer";
import { configureStore } from "@reduxjs/toolkit";
import { setupListeners } from "@reduxjs/toolkit/query";
import { useMemo } from "react";
import { createLogger } from "redux-logger";
import {
    FLUSH,
    PAUSE,
    PERSIST,
    PURGE,
    REGISTER,
    REHYDRATE,
    persistReducer,
    persistStore,
} from "redux-persist";
import storage from "redux-persist/lib/storage";
import createSagaMiddleware from "redux-saga";


const persistConfig = {
    key: "root",
    storage,
    blacklist: ["api", 'toastMessage'],
    // whitelist: [
    // ],
    // stateReconciler: hardSet,
    debug: isLocal,
};
const persistedReducer = persistReducer(persistConfig, rootReducer);
const sagaMiddleware = createSagaMiddleware();
const appLogger: any = createLogger({
    collapsed: isLocal,
    duration: isLocal,
    diff: isLocal,
});
const middlewares = [
    apiSlice.middleware,
    categoryApi.middleware,
    sagaMiddleware,
];
if (isLocal) {
    middlewares.push(appLogger);
}
let store: any = configureStore({
    reducer: persistedReducer,
    // Adding the api middleware enables caching, invalidation, polling,
    // and other useful features of `rtk-query`.
    middleware: (gDM) =>
        gDM({
            serializableCheck: {
                ignoredActions: [
                    FLUSH,
                    REHYDRATE,
                    PAUSE,
                    PERSIST,
                    PURGE,
                    REGISTER,
                ],
            },
        }).concat(middlewares)
});
sagaMiddleware.run(rootSaga);
export const initializeStore = (preloadedState: RootState) => {
    let _store: any = store;
    // After navigating to a page with an initial Redux state, merge that state
    // with the current state in the store, and create a new store
    if (preloadedState && store) {
        _store = {
            ...store.getState(),
            ...preloadedState,
        };
        // Reset the current store
        store = undefined;
    }
    // For SSG and SSR always create a new store
    if (typeof window === "undefined") return _store;
    // Create the store once in the client
    if (!store) store = _store;
    return _store;
};
setupListeners(store.dispatch);
const makeStore = () => store;
const persistor = persistStore(store);

export const useStore = (initialState: RootState) =>
    useMemo(() => initializeStore(initialState), [initialState]);
export type RootState = ReturnType<typeof store.getState>;
export type AppStore = ReturnType<typeof store>;
export type AppDispatch = typeof store.dispatch;

export { persistor, store };

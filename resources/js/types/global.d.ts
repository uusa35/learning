import { AxiosInstance } from 'axios';
import { route as ziggyRoute, Config as ZiggyConfig } from 'ziggy-js';

declare global {
    interface Window {
        axios: AxiosInstance;
        Pusher: any;
        Echo: any;
    }
    var route: typeof ziggyRoute;
    var Ziggy: ZiggyConfig;
}

import { Configuration } from '../types';

export const defaultConfig: Configuration = {
    streams: {

    },
    http   : {
        baseURL: '/api',
        etag: {
            enabled    : true,
            manifestKey: 'streams',
        },
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    },
};

import { AxiosRequestConfig } from 'axios';

export interface IServiceProvider {
}

export interface IConfig {
    prefix?: string;
    debug?: boolean;
    csrf?: string;
    delimiters?: [ string, string ];
    http?: AxiosRequestConfig;
}

//# sourceMappingURL=types.d.ts.map

import { Application } from './Application';
export declare function toJS(v: any): any;
export interface Config<T> {
    get<T>(path: string, defaultValue?: any): T;
}
export declare class Config<T> {
    protected data: Partial<T>;
    static app: Application;
    constructor(data?: Partial<T>);
    get: <T_1>(path: string, defaultValue?: any) => T_1;
    set: (path: string, value: any) => Partial<T>;
    has: (path: string) => boolean;
    unset: (path: string) => boolean;
    merge: (value: any) => any;
    mergeAt: (path: string, value: any) => Partial<T>;
    pushTo: (path: string, ...items: any[]) => Partial<T>;
    raw: () => T;
    getClone: <T_1>(path?: string, defaultValue?: any) => T_1;
    toJS: (path?: string) => any;
    proxy: (path: string) => Config<T>;
    static proxied<T>(data: any): Config<T>;
}
export declare function configProxy(path: string): PropertyDecorator;
export declare function configValue(path: string): PropertyDecorator;

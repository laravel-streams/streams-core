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
    set: (path: string, value: any) => any;
    has: (path: string) => any;
    unset: (path: string) => any;
    merge: (value: any) => any;
    mergeAt: (path: string, value: any) => any;
    pushTo: (path: string, ...items: any[]) => any;
    raw: () => T;
    getClone: <T_1>(path?: string, defaultValue?: any) => T_1;
    toJS: (path?: string) => any;
    proxy: (path: string) => Config<T>;

    static proxied<T>(data: any): Config<T>;
}

export declare function configProxy(path: string): PropertyDecorator;

export declare function configValue(path: string): PropertyDecorator;

//# sourceMappingURL=Config.d.ts.map

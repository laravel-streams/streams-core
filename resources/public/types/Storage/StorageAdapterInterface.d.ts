export interface StorageAdapterInterface {
    get<T>(key: string, defaultValue?: any): T;
    set(key: string, value: any): this;
    has(key: string): boolean;
    unset(key: string): this;
    clear(): this;
}

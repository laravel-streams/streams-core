export declare class Repository<T = any> {
    protected items: T;
    constructor(items?: T);
    get<T>(path: string, defaultValue?: any): T;
    set(path: string | T, value?: any): this;
    has(path: string): boolean;
    static asProxy<T>(items?: T): Repository<T> & T;
}

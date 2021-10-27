export declare class Repository<Type = any> {
    protected items: Type;
    constructor(items?: Type);
    /**
     * Get a config value.
     *
     * @param key
     * @param defaultValue
     * @returns mixed
     */
    get<Type>(key: string, defaultValue?: any): Type;
    /**
     * Set a config value.
     *
     * @param key
     * @param value
     * @returns this
     */
    set(key: string | Type, value?: any): this;
    /**
     * Check if a value exists.
     *
     * @param key
     * @returns
     */
    has(key: string): boolean;
    static asProxy<Type>(items?: Type): Repository<Type> & Type;
}

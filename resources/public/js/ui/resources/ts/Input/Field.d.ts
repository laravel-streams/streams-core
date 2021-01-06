export declare abstract class Field {
    element: HTMLElement;
    options?: any;
    defaults: any;

    init(selector: string, options?: any): Promise<this>;

    protected abstract load(): Promise<any>;
}

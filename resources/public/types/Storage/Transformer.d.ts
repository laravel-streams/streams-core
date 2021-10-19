export declare class Transformer {
    static typePrefix: string;
    static get prefixesLength(): number;
    static compress(value: any): string;
    static decompress(value: any): any;
    static encode(value: any): any;
    static decode(value: any): any;
}

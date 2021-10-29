
export namespace fields {

    export interface Types {
        string: string;
        url: string;
        text: string;
        hash: string;
        slug: string;
        email: string;
        markdown: string;
        template: string;
        number: number;
        integer: number;
        float: number;
        decimal: number;
        boolean: boolean;
        array: Array<any>;
        prototype: object;
        object: object;
        image: any;
        file: any;
        datetime: string;
        date: string;
        time: string;
        select: string;
        multiselect: string[];
        collection: Array<any>;
        entry: any;
        entries: any;
        multiple: any;
        polymorphic: any;
        relationship: any;
        color: any;
    }

    export type Type = keyof Types
}

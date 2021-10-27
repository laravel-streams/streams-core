export declare namespace ui {
    namespace table {
        interface Button {
            href?: string;
        }
        type Buttons<T extends string[]> = {
            [P in keyof T]: Button;
        };
        interface Table<COLUMNS extends string[], BUTTONS extends string[]> {
            columns: COLUMNS;
            buttons: Buttons<BUTTONS>;
            [key: string]: any;
        }
    }
}
export declare namespace fields {
    interface Types {
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
    type Type = keyof Types;
}


export namespace ui {
    export namespace table {
        export interface Button {
            href?: string;
        }

        export type Buttons<T extends string[]> = {
            [P in keyof T]: Button
        }

        export interface Table<COLUMNS extends string[],
            BUTTONS extends string[],
            > {
            columns: COLUMNS,
            buttons: Buttons<BUTTONS>

            [ key: string ]: any
        }
    }
}

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

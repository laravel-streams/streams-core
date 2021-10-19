import { Field } from '../Streams';

export interface IStreamMeta {
    parameters: Record<string, string>;
    query: string[];
}

export type IStreamLinks<K> = {
    [T in keyof K]: string
}

export interface IStreamResponse<T extends any=any, META extends IStreamMeta=IStreamMeta,LINKS=IStreamLinks<'self' | 'entries'>> {
    data: T;
    meta: META;
    links: LINKS;
    errors?: string[]|Record<string, string|string[]>
}

export interface IBaseStream<ID extends string = string> {
    id: ID
    created_at: string
    updated_at: string
    name: string
    source: {
        type: string
        [ key: string ]: any
    },
    fields: Record<string, fields.Type|Field>
    rules?: Record<string, string | object>
}


export interface IStream<ID extends string = string> extends IBaseStream<ID> {
    handle?: ID
    routes?: Array<any>,
    validators?: Array<any>,
    config?: Record<string, any>
}

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

export interface IStreams {
    users: streams.Users;
    pages: streams.Pages;
    addons: IBaseStream<'addons'>;
    docs: IBaseStream<'docs'>;
}

export interface IEntries {
    users: entries.Users;
    pages: entries.Pages;
}

export namespace fields {
    export type Relationship<RELATED extends keyof IEntries> = IEntries[RELATED]

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

export namespace streams {

    export interface Users extends IBaseStream<'users'> {
        ui: {
            table: ui.table.Table<[ 'id', 'email' ], [ 'edit' ]>
            form: any[]
            [ key: string ]: any
        };
    }

    export interface Pages extends IBaseStream<'pages'> {
        ui: {
            table: ui.table.Table<[ 'id', 'email' ], [ 'edit' ]>
            form: any[]
            [ key: string ]: any
        };
    }
}

export namespace entries {
    export interface Users {
        id: number;
        name: string;
        email: string;
        password: string;
        relative: fields.Relationship<'users'>;
    }

    export interface Pages {}
}


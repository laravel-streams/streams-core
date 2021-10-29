export * from './config';
export * from './streams';
export * from './fields';
import {Streams as streams} from './streams'
declare module './streams' {
    export namespace Streams.Ui {
        export interface Ui {
            form?: streams.Ui.Form.Form
            table?: streams.Ui.Table.Table
        }
    }
}

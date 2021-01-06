import EasyMDE   from 'easymde';
import { Field } from './Field';

export declare class Markdown extends Field {
    EasyMDE: typeof EasyMDE;
    easyMDE: EasyMDE;
    defaults: {
        EasyMDE: {};
    };

    protected load(): Promise<void>;
}

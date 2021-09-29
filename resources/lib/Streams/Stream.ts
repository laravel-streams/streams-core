import { FieldCollection } from './FieldCollection';
import { Field } from './Field';
import { Repository } from './Repository';
import { Criteria } from '@/Streams/Criteria';
import { IBaseStream } from '@/types/streams';

export interface Stream<ID extends string = string> extends IBaseStream<ID>{}
export class Stream<ID extends string = string> {
    constructor(stream: IBaseStream<ID>) {
        Object.assign(this, stream);
    }

    protected _repository: Repository<ID>;
    protected _rules: Array<any>;
    protected _validators: Array<any>;
    protected _fields: Field[] | FieldCollection;

    get repository(): Repository<ID> {
        if ( !this._repository ) {
            this._repository = new Repository<ID>(this);
        }
        return this._repository;
    }

    entries(): Criteria<ID> {
        return this.repository.newCriteria();
    };

    // validator;
    // hasRule;
    // getRule;
    // ruleParameters;
    isRequired;
    config;
    meta;
    cached;
    cache;
    forget;
    flush;
    toArray;
    toJson;
    jsonSerialize;
    __toString;
    onInitializing;
    onInitialized;
    extendInput;
    importInput;
    normalizeInput;
    fieldsInput;
    merge;

}

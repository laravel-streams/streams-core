import { FieldCollection } from './FieldCollection';
import { Field } from './Field';
import { Repository } from './Repository';


export class Stream {
    handle: string;
    protected _repository: Repository;
    protected _rules: Array<any>;
    protected _validators: Array<any>;
    protected _fields: Field[] | FieldCollection;

    get repository(): Repository {
        if ( !this._repository ) {
            this._repository = new Repository(this);
        }
        return this._repository;
    }

    entries;
    validator;
    hasRule;
    getRule;
    ruleParameters;
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

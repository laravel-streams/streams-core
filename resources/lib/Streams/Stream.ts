import { Field } from './Field';
import { Repository } from './Repository';
import { Criteria } from '@/Streams/Criteria';
import { IBaseStream, IStreamLinks, IStreamMeta } from '@/types/streams';

export interface Stream<ID extends string = string> extends Omit<IBaseStream<ID>,'fields'> {}

export class Stream<ID extends string = string> {
    constructor(
        stream: IBaseStream<ID>,
        public readonly meta?: IStreamMeta,
        public readonly links?: IStreamLinks<'self' | 'entries'>,
    ) {
        if(stream.fields){
            this.fields=new Map(Object.entries(stream.fields).map(([key,field]) => [key,new Field(field)]))
            delete stream.fields;
        }
        Object.assign(this, stream);
    }

    protected _repository: Repository<ID>;
    protected _rules: Array<any>;
    protected _validators: Array<any>;
    public fields: Map<string, Field>

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

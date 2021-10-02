import { Stream } from './Stream';
import { Entry } from './Entry';
import { EntryCollection } from './EntryCollection';
import { IBaseStream, streams } from '@/types';
import { IStreams } from '@/types/streams';
import { injectable } from 'inversify';
import { inject } from '@/Foundation';
import { Http } from '@/Streams/Http';

export type OrderByDirection = 'asc'|'desc'
export type ComparisonOperator =
    | '>'
    | '<'
    | '=='
    | '!='
    | '>='
    | '<='
    | '!<'
    | '!>'
    | '<>'

export const comparisonOperators:ComparisonOperator[] = [ '>','<','==','!=','>=','<=','!<','!>','<>']

export type LogicalOperator =
    | 'BETWEEN'
    | 'EXISTS'
    | 'OR'
    | 'AND'
    | 'NOT'
    | 'IN'
    | 'ALL'
    | 'ANY'
    | 'LIKE'
    | 'IS NULL'
    | 'UNIQUE'
export const logicalOperators:LogicalOperator[] = [ 'BETWEEN','EXISTS','OR','AND','NOT','IN','ALL','ANY','LIKE','IS NULL','UNIQUE']
export const operators:Operator[] = [].concat(comparisonOperators).concat(logicalOperators);

export type Operator = ComparisonOperator | LogicalOperator

const isOperator = (value:any):value is Operator => operators.includes(value);

export interface CriteriaStatement {
    name:string
    [key:string]: any
}

@injectable()
export class Criteria<ID extends string=string> {
    @inject('streams.http') http:Http
    // parameters
    // adapter

    protected statements:CriteriaStatement[] = []

    constructor(protected stream: Stream) {}

    protected compileStatements(){
        let params = {}
        for(const s of this.statements){
            let param = s;
            delete param.name;
            params[s.name] = s;
        }
        return params;
    }

    async all(): Promise<EntryCollection> {return; }

    find(): this {return this;}

    async first(): Promise<Entry<ID> & IBaseStream<ID>> {return ;}

    cache(): this {return this;}

    orderBy(key:string, direction:OrderByDirection='desc'): this {
        this.statements.push({name: 'orderBy', key, direction})
        return this;
    }

    limit(value:number): this {
        this.statements.push({name: 'limit', value})
        return this;}

    where(key:string,value:any):this
    where(key:string,operator:Operator,value:any):this
    where(...args):this{
        let key:string,
            operator:Operator,
            value:any;
        if(args.length === 2){
            key = args[0];
            operator = '=='
            value = args[1];
        } else { // if(args.length === 3)
            key = args[0];
            operator = args[1]
            value = args[2];
        }
        if(!isOperator(operator)){
            throw new Error(`Criteria where() operator "${operator}" not valid `)
        }
        this.statements.push({name:'where',key,operator,value})
        return this;
    }

    orWhere(): this {return this;}

    async get(): Promise<EntryCollection> {
        let params = this.compileStatements();
        const response = await this.http.getEntries(this.stream.id, params);
        return new EntryCollection(response.data)
    }

    count(): number {return 0;}

    create(): this {return this;}

    save(): this {return this;}

    delete(): this {return this;}

    truncate(): this {return this;}

    paginate(): this {return this;}

    newInstance(): this {return this;}

    getParameters(): this {return this;}

    setParameters(): this {return this;}
}

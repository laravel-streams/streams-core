import { Stream } from './Stream';
import { Entry } from './Entry';
import { EntryCollection, PaginatedEntryCollection } from './EntryCollection';
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
const ensureArray = (value:any) => Array.isArray(value) ? value : [value];

export interface CriteriaStatement {
    name:string
    value:any
    // [key:string]: any
}

@injectable()
export class Criteria<ID extends string=string> {
    
    @inject('streams.http') http:Http
    // parameters
    // adapter

     statements:CriteriaStatement[] = []

    constructor(protected stream: Stream) {}

    compileStatements(){
        return this.statements.map(statement => ({[statement.name]: ensureArray(statement.value)}));
    }

    protected addStatement(name:string, value:any|any[]){
        this.statements.push({name, value})
        return this;
    }

    async all(): Promise<EntryCollection> {return; }

    find(): this {return this;}

    async first(): Promise<Entry<ID> & IBaseStream<ID>> {return ;}

    cache(): this {return this;}

    orderBy(key:string, direction:OrderByDirection='desc'): this {
        this.addStatement( 'orderBy',[key, direction])
        return this;
    }

    limit(value:number): this {
        this.addStatement( 'limit',value)
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
        this.addStatement( 'where',[key,operator,value])
        return this;
    }

    orWhere(): this {return this;}

    async get<T>(): Promise<EntryCollection> {
        let query = this.compileStatements();
        const response = await this.http.getEntries<T[],'entries'>(this.stream.id, { query },{});
        return EntryCollection.fromResponse<T>(response, this.stream)
    }

    count(): number {return 0;}

    create(): this {return this;}

    save(): this {return this;}

    delete(): this {return this;}

    truncate(): this {return this;}

    async paginate<T>(per_page:number=100, page:number=1):Promise<PaginatedEntryCollection> {
        let query = this.compileStatements();
        const response = await this.http.getEntries<T[], 'paginated'>(this.stream.id, { query },{paginate:true,per_page,page});
        return PaginatedEntryCollection.fromResponse<T>(response, this.stream)
    }

    newInstance(): this {return this;}

    getParameters(): this {return this;}

    setParameters(): this {return this;}
}

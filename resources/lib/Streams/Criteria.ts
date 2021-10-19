import { Stream } from './Stream';
import { Entry } from './Entry';
import { EntryCollection, PaginatedEntryCollection } from './EntryCollection';
import { IBaseStream, streams } from '../types';
import { IStreams } from '../types/streams';
import { injectable } from 'inversify';
import { inject } from '../Foundation';
import { Http } from '../Streams/Http';

export type OrderByDirection = 'asc' | 'desc';

export type ComparisonOperator =
    | '>'
    | '<'
    | '=='
    | '!='
    | '>='
    | '<='
    | '!<'
    | '!>'
    | '<>';

export const comparisonOperators: ComparisonOperator[] = ['>', '<', '==', '!=', '>=', '<=', '!<', '!>', '<>'];

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
    | 'UNIQUE';

export const logicalOperators: LogicalOperator[] = ['BETWEEN', 'EXISTS', 'OR', 'AND', 'NOT', 'IN', 'ALL', 'ANY', 'LIKE', 'IS NULL', 'UNIQUE'];

export const operators: Operator[] = [].concat(comparisonOperators).concat(logicalOperators);

export type Operator = ComparisonOperator | LogicalOperator;

const isOperator = (value: any): value is Operator => operators.includes(value);

const ensureArray = (value: any) => Array.isArray(value) ? value : [value];

export interface CriteriaParameter {
    name: string
    value: any
    // [key:string]: any
}

@injectable()
export class Criteria<ID extends string = string> {

    @inject('streams.http') http: Http

    parameters: CriteriaParameter[] = []

    /**
     * Create a new instance.
     *
     * @param stream
     */
    constructor(protected stream: Stream) { }

    /**
     * Find an entry by ID.
     *
     * @param id
     * @returns
     */
    async find<ID extends string>(id: ID): Promise<Entry> {
        return this.where('id', id).first();
    }

    /**
     * Return the first result.
     *
     * @returns
     */
    async first(): Promise<Entry<ID> & IBaseStream<ID>> {

        let collection = await this.limit(1).get();

        return collection[0];
    }

    cache(): this { return this; }

    /**
     * Order the query by field/direction.
     *
     * @param key
     * @param direction
     * @returns
     */
    orderBy(key: string, direction: OrderByDirection = 'desc'): this {

        this.addParameter('orderBy', [key, direction]);

        return this;
    }

    /**
     * Limit the entries returned.
     *
     * @param value
     * @returns
     */
    limit(value: number): this {

        this.addParameter('limit', value);

        return this;
    }

    /**
     * Constrain the query by a typical
     * field, operator, value argument.
     *
     * @param key
     * @param value
     */
    where(key: string, operator: Operator, value: any, nested: any): this
    where(key: string, operator: Operator, value: any): this
    where(key: string, value: any): this
    where(...args): this {

        let key: string,
            operator: Operator,
            value: any,
            nested: null;

        if (args.length === 2) {
            key = args[0];
            operator = '=='
            value = args[1];
        } else if (args.length === 3) {
            key = args[0];
            operator = args[1]
            value = args[2];
        } else if (args.length === 4) {
            key = args[0];
            operator = args[1]
            value = args[2];
            nested = args[3];
        }

        if (!isOperator(operator)) {
            throw new Error(`Criteria where() operator "${operator}" not valid `);
        }

        this.addParameter('where', [key, operator, value, nested]);

        return this;
    }

    orWhere(key: string, operator: Operator, value: any): this
    orWhere(key: string, value: any): this
    orWhere(...args): this {

        let key: string,
            operator: Operator,
            value: any;

        if (args.length === 2) {
            key = args[0];
            operator = '=='
            value = args[1];
        } else {
            key = args[0];
            operator = args[1]
            value = args[2];
        }

        if (!isOperator(operator)) {
            throw new Error(`Criteria orWhere() operator "${operator}" not valid `);
        }

        this.addParameter('where', [key, operator, value, 'or']);

        return this;
    }

    /**
     * Get the criteria results.
     *
     * @returns
     */
    async get<T>(): Promise<EntryCollection> {

        let query = this.compileStatements();

        const response = await this.http.getEntries<T[], 'entries'>(this.stream.id, { query }, {});

        return EntryCollection.fromResponse<T>(response, this.stream)
    }

    //count(): number { return 0; }

    /**
     * Create a new entry.
     *
     * @param attributes
     * @returns
     */
     async create(attributes: any): Promise<Entry> {

        let entry = this.newInstance(attributes);

        await entry.save()

        return entry;
    }

    /**
     * Save an entry.
     *
     * @param entry
     * @returns
     */
     async save(entry: Entry): Promise<Boolean> {

        let result = await entry.save();

        return result;
    }

    delete(): this { return this; }

    //truncate(): this { return this; }

    /**
     * Get paginated criteria results.
     *
     * @param per_page
     * @param page
     * @returns
     */
    async paginate<T>(per_page: number = 100, page: number = 1): Promise<PaginatedEntryCollection> {

        let query = this.compileStatements();

        const response = await this.http.getEntries<T[], 'paginated'>(this.stream.id, { query }, { paginate: true, per_page, page });

        return PaginatedEntryCollection.fromResponse<T>(response, this.stream);
    }

    /**
     * Return an entry instance.
     *
     * @param attributes
     * @returns Entry
     */
    public newInstance(attributes: any): Entry {
        return new Entry(this.stream, attributes, true);
    }

    /**
     * Get the parameters.
     *
     * @returns
     */
    public getParameters(): any {
        return this.parameters;
    }

    /**
     * Set the parameters.
     *
     * @param parameters
     * @returns
     */
    public setParameters(parameters: any): this {

        this.parameters = parameters;

        return this;
    }

    /**
     * Add a statement.
     *
     * @param name
     * @param value
     * @returns
     */
    protected addParameter(name: string, value: any | any[]) {

        this.parameters.push({ name, value })

        return this;
    }

    /**
     * Return standardized parameters.
     *
     * @returns
     */
    public compileStatements() {
        return this.parameters.map(statement => ({ [statement.name]: ensureArray(statement.value) }));
    }
}

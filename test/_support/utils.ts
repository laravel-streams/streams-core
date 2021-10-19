import 'reflect-metadata';
import { dirname, isAbsolute, join } from 'path';
import { existsSync, readFileSync, unlinkSync, writeFileSync } from 'fs';
import { config } from 'dotenv';

export function getBigDataObject(){
    return require('./package-lock-data.json');
}

export function getDotEnvPath(): string | false {
    let dirPath = __dirname;
    while ( true ) {
        let envPath = join(dirPath, '.env');
        if ( existsSync(envPath) ) {
            return envPath;
        }
        if ( dirname(dirPath) === dirPath ) {
            return false;
        }
        dirPath = dirname(dirPath);
    }
}

export function getProjectRootPath(): string | false {
    let dirPath = __dirname;
    while ( true ) {
        let rootPath = join(dirPath, 'artisan');
        if ( existsSync(rootPath) ) {
            return dirname(rootPath);
        }
        if ( dirname(dirPath) === dirPath ) {
            return false;
        }
        dirPath = dirname(dirPath);
    }
}

export function getDotEnv(): any {
    let dotEnvPath = getDotEnvPath();
    let parsed     = {};
    if ( dotEnvPath ) {
        let env = config({
            path    : dotEnvPath,
            encoding: 'utf8',
        });
        parsed  = env.parsed;
    }
    return parsed;
}

export function getEnv<T = any>(): ProxyEnv<T> {
    getDotEnv();
    return proxyEnv(process.env) as any;
}

export const enum ProxyFlags {
    IS_PROXY = '__s_is_proxy',
    UNPROXY  = '__s_unproxy'
}

export type ProxyEnv<T> =
    T
    & {
        [ key: string ]: any
        get<T>(key: string, defaultValue?: any): T
        set(key: string, value: any): boolean
        has(key: string): boolean

    }

export function proxyEnv<T extends object>(env: T): ProxyEnv<T> {
    const get = (key: string, defaultValue?: any) => env[ key ];
    const has = (key: string) => env[ key ] !== undefined;
    const set = (key: string, value: any) => env[ key ] = value;
    return new Proxy(env, {
        get(target: any, p: string | symbol, receiver: any): any {
            if ( Reflect.has(target, p) ) {
                return Reflect.get(target, p, receiver);
            }
            let name = p.toString();
            if ( name === ProxyFlags.IS_PROXY ) return true;
            if ( name === ProxyFlags.UNPROXY ) return target;
            if ( name === 'get' ) return get;
            if ( name === 'has' ) return has;
            if ( name === 'set' ) return set;
        },
        set(target: any, p: string | symbol, value: any, receiver: any): boolean {
            return Reflect.set(target, p, value, receiver);
        },
        has(target: any, p: string | symbol): boolean {
            return Reflect.has(target, p);
        },
    }) as any;
}

export class FS {
    rootPath: string;

    constructor() {
        let path = getProjectRootPath();
        if ( path ) {
            this.rootPath = path;
        }
    }

    path(...parts: string[]): string {return join(this.rootPath, ...parts); }

    resolvePath(path: string) {return isAbsolute(path) ? path : this.path(path); }

    createStream(name:string, data:any){
        this.delete(`streams/${name}.json`);
        this.delete(`streams/data/${name}.json`);
        this.create(`streams/${name}.json`,data);
    }

    create(path: string, data: any, override: boolean = true): boolean {
        path = this.resolvePath(path);
        if ( existsSync(path) ) {
            if ( !override ) {
                return false;
            }
            unlinkSync(path);
        }
        if(typeof data !== 'string'){
            data=JSON.stringify(data,null,4)
        }
        writeFileSync(path, data, 'utf8');
        return true;
    }

    get(path: string): string {
        path = this.resolvePath(path);
        if ( !existsSync(path) ) {
            throw new Error(`Could not read file from "${path}". File does not exist`);
        }
        return readFileSync(path, 'utf8');
    }

    delete(path: string): boolean {
        path = this.resolvePath(path);
        if ( existsSync(path) ) {
            unlinkSync(path);
        }
        return true;
    }

    exists(path: string): boolean {
        return existsSync(this.resolvePath(path));
    }
}

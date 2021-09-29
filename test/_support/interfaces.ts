
export interface IPerson {
    _id?:           string;
    index:         number;
    guid?:          string;
    isActive?:      boolean;
    balance?:       string;
    picture?:       string;
    age?:           number;
    eyeColor?:      string;
    name?:          string;
    gender?:        string;
    company?:       string;
    email?:         string;
    phone?:         string;
    address?:       IAddress;
    about?:         string;
    registered?:    string;
    latitude?:      number;
    longitude?:     number;
    tags?:          string[];
    friends?:       IFriend[];
    greeting?:      string;
    favoriteFruit?: string;
}

export interface IAddress {
    number?: number;
    street?: string;
    city?:   string;
    state?:  string;
}

export interface IFriend {
    id?:   number;
    name?: string;
}

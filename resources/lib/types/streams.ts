namespace Streams.Core.Field {
  export type FieldType = {
    name: string;
    description: string;
    rules: any;
    config: { [key: string]: any };
  };
}
namespace Streams.Core.Stream {
  export type Stream = {
    handle: string;
    repository: any;
    rules: Array<any>;
    validators: Array<any>;
    fields: any | Array<any>;
  };
}
namespace Streams.Ui.Button {
  export type Button = {
    template: string;
    tag: string;
    url: string;
    text: any;
    entry: any;
    policy: any;
    enabled: boolean;
    primary: boolean;
    disabled: boolean;
    type: string;
    classes: Array<any>;
    attributes: { [key: string]: any };
    handle: string;
    async: boolean;
    component: any;
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  };
}
namespace Streams.Ui.ControlPanel {
  export type ControlPanel = {
    handle: string;
    template: string;
    async: boolean;
    component: any;
    classes: Array<any>;
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  };
}
namespace Streams.Ui.Form {
  export type Form = {
    values: { [key: string]: any };
    options: { [key: string]: any };
    rules: { [key: string]: any };
    validators: { [key: string]: any };
    errors: Array<any>;
    sections: Array<any>;
    fields: any | Array<Streams.Core.Field.FieldType>;
    actions: any | Array<Streams.Ui.Form.Action.Action>;
    buttons: any | Array<Streams.Ui.Button.Button>;
    handle: string;
    template: string;
    async: boolean;
    component: any;
    classes: Array<any>;
    attributes: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  };
}
namespace Streams.Ui.Form.Action {
  export type Action = {
    action: boolean;
    template: string;
    tag: string;
    url: string;
    text: any;
    entry: any;
    policy: any;
    enabled: boolean;
    primary: boolean;
    disabled: boolean;
    type: string;
    classes: Array<any>;
    attributes: { [key: string]: any };
    handle: string;
    async: boolean;
    component: any;
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  };
}
namespace Streams.Ui.Input {
  export type Input = {
    handle: string;
    template: string;
    async: boolean;
    component: any;
    classes: Array<any>;
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  };
}
namespace Streams.Ui.Support {
  export type Component = {
    handle: string;
    template: string;
    async: boolean;
    component: any;
    classes: Array<any>;
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  };
}
namespace Streams.Ui.Table {
  export type Table = {
    rows: any | Array<Streams.Ui.Table.Row.Row>;
    views: any | Array<Streams.Ui.Table.View.View>;
    actions: any | Array<Streams.Ui.Table.View.View>;
    filters: any | Array<Streams.Ui.Table.Filter.Filter>;
    buttons: any | Array<Streams.Ui.Button.Button>;
    handle: string;
    template: string;
    async: boolean;
    component: any;
    classes: Array<any>;
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  };
}
namespace Streams.Ui.Table.Action {
  export type Action = {
    action: boolean;
    template: string;
    tag: string;
    url: string;
    text: any;
    entry: any;
    policy: any;
    enabled: boolean;
    primary: boolean;
    disabled: boolean;
    type: string;
    classes: Array<any>;
    attributes: { [key: string]: any };
    handle: string;
    async: boolean;
    component: any;
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  };
}
namespace Streams.Ui.Table.Column {
  export type Column = {
    entry: any;
    view: string;
    direction: string;
    prefix: string;
    value: any;
    heading: any;
    wrapper: any;
    sortable: boolean;
    field: any;
    handle: string;
    template: string;
    async: boolean;
    component: any;
    classes: Array<any>;
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  };
}
namespace Streams.Ui.Table.Filter {
  export type Filter = {
    active: boolean;
    exact: boolean;
    query: any;
    handle: string;
    template: string;
    async: boolean;
    component: any;
    classes: Array<any>;
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  };
}
namespace Streams.Ui.Table.Row {
  export type Row = {
    columns: any | Array<Streams.Ui.Table.Column.Column>;
    buttons: any | Array<Streams.Ui.Button.Button>;
    key: string | number;
    entry: any;
    table: Streams.Ui.Table.Table;
    handle: string;
    template: string;
    async: boolean;
    component: any;
    classes: Array<any>;
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  };
}
namespace Streams.Ui.Table.View {
  export type View = {
    text: string;
    icon: string;
    label: string;
    prefix: string;
    actions: any | Array<Streams.Ui.Table.View.View>;
    columns: Array<Streams.Ui.Table.Column.Column>;
    entries: Array<any>;
    filters: any | Array<Streams.Ui.Table.Filter.Filter>;
    buttons: any | Array<Streams.Ui.Button.Button>;
    handler: any;
    query: any;
    active: boolean;
    context: string;
    handle: string;
    template: string;
    async: boolean;
    component: any;
    classes: Array<any>;
    attributes: { [key: string]: any };
    options: { [key: string]: any };
    data: any;
    response: any;
    stream: Streams.Core.Stream.Stream;
  };
}

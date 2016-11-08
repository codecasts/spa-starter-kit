
export function set (label, obj) {
    window.localStorage.setItem(label, JSON.stringify(obj))
}

export function get (label) {
    const string = window.localStorage.getItem(label)
    return JSON.parse(string)
}
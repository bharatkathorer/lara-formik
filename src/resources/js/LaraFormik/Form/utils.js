import {router} from "@inertiajs/vue3";
import tailwindConfig from '../../../../tailwind.config.js'
// export const getParameters = () => {
//     let uri = window.location.href.split('?');
//     if (uri?.length === 2) {
//         let vars = uri[1].split('&');
//         let getVars = {};
//         let tmp = '';
//         vars.forEach(function (v) {
//             tmp = v.split('=');
//             if (tmp?.length === 2) if (tmp[0] !== 'page') {
//                 getVars[tmp[0]] = decodeURIComponent(tmp[1]);
//             }
//         });
//         console.log(getVars);
//         return getVars;
//     }
//     return [];
// }

export const tailwindColors = tailwindConfig?.theme?.extend?.colors ?? {};
export const getParameters = () => {
    let uri = window.location.href.split('?');  // Split the URL at the query string
    let getVars = {};  // To store the query parameters

    // If there is a query string part (i.e., URL contains '?')
    if (uri?.length === 2) {
        let vars = uri[1].split('&');  // Split the query string into individual key-value pairs

        vars.forEach(function (v) {
            let tmp = v.split('=');
            if (tmp?.length === 2) {  // Only process valid key-value pairs
                let key = decodeURIComponent(tmp[0]);  // Decode the key
                let value = decodeURIComponent(tmp[1]);  // Decode the value

                // If the value is empty, consider it as `null` (or you can skip it)
                if (value === "") {
                    value = null;
                }

                // Check if the key contains array-like brackets '[]' or '[index]'
                if (key.includes('[')) {
                    const baseKey = key.split('[')[0];  // Extract the base key
                    const index = key.match(/\[(\d+)\]/)?.[1];  // Extract the index inside the square brackets
                    if (index !== undefined) {
                        // Initialize the array if it doesn't exist
                        if (!getVars[baseKey]) {
                            getVars[baseKey] = [];
                        }
                        // Add the value to the array at the correct index
                        getVars[baseKey][index] = value;
                    } else {
                        // If it's a plain array-like key (e.g., "course[]")
                        if (!getVars[baseKey]) {
                            getVars[baseKey] = [];
                        }
                        getVars[baseKey].push(value);
                    }
                } else {
                    // For regular key-value pairs, just assign the value
                    if (key !== 'page') {
                        getVars[key] = value;
                    }
                }
            }
        });

        // Remove any empty keys (like "?")
        if (getVars.hasOwnProperty('?')) {
            delete getVars['?'];
        }

        return getVars;
    }

    // Return an empty object if there are no query parameters
    return {};
};

export const makeParameter = (name = false, value = false, start = true) => {
    let data = getParameters();
    if (name) {
        if (typeof name == 'string') {
            data[name] = value;
        } else if (typeof name == 'object') {
            Object.keys(name).forEach((key) => {
                data[key] = name[key];
            })
        }
    }

    let param = null;

    param = Object.entries(data)
        .filter(([key, value]) => !(value == null || value === '' || value === undefined || value === false))
        .map(([key, value]) => {
            if (Array.isArray(value)) {
                return value.map(val => `${key}[]=${val}`).join('&');
            } else {
                return `${key}=${value}`;
            }
        })
        .join('&');

    if (param !== null) {
        return `${(start) ? '?' : '&'}${param}`
    }
    return '';
    //
    // Object.keys(data).forEach((key) => {
    //     if (data[key] != null) {
    //         param += (param === '' && start) ? '?' : '&';
    //         param += `${key}=${data[key]}`;
    //     }
    // });
    // return param;
}
export const setPath = (page) => {
    let url = window.location.origin;
    const pathname = window.location.pathname;
    if (pathname !== '/') {
        url = url + pathname;
    }
    router.replace(url + page);
    // window.history.replaceState('', '', url + page);
}

export const InputColors = (mode) => {
    switch (mode) {
        case "primary":
            return {
                text: 'text-primary/90 hover:text-primary-active',
                active: 'hover:text-primary-active text-primary border-primary-light focus:border-primary focus:ring-primary',
            }
        case "secondary":
            return {
                text: 'text-secondary/90 hover:text-secondary-active',
                active: 'hover:text-secondary-active text-secondary border-secondary-light focus:border-secondary focus:ring-secondary',
            }
        case "success":
            return {
                text: 'text-success/90 hover:text-success-active',
                active: 'hover:text-success-active text-success border-success-light focus:border-success focus:ring-success',
            }
        case "warning":
            return {
                text: 'text-warning/90 hover:text-warning-active',
                active: 'hover:text-warning-active text-warning border-warning-light focus:border-warning focus:ring-warning',
            }
        case "danger":
            return {
                text: 'text-danger/90 hover:text-danger-active',
                active: 'hover:text-danger-active text-danger border-danger-light focus:border-danger focus:ring-danger',
            }
        case "info":
            return {
                text: 'text-info/90 hover:text-info-active',
                active: 'hover:text-info-active text-info border-info-light focus:border-info focus:ring-info',
            }
        case "light":
            return {
                text: 'text-light/90 hover:text-light-active',
                active: 'hover:text-light-active text-light border-light-light focus:border-light focus:ring-light',
            }
        case "dark":
            return {
                text: 'text-dark/90 hover:text-dark-active',
                active: 'hover:text-dark-active text-dark border-dark-light focus:border-dark focus:ring-dark',
            }
        default:
            return {
                text: 'text-primary/90 hover:text-primary-active',
                active: 'hover:text-primary-active text-primary border-primary-light focus:border-primary focus:ring-primary',
            }
    }

}

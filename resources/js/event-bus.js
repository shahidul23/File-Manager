import mitt from 'mitt'

export const FILE_UPLOAD_START = 'FILE_UPLOAD_START'

export const SHOW_ERROR_DIALOG = 'SHOW_ERROR_DIALOG'



export const emitter = mitt()


export function showErrorDialog(message) {
    emitter.emit(SHOW_ERROR_DIALOG, {message})
}
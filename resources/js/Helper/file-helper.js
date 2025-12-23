export function isImageFile(file) {
    return /^image\/\w+$/.test(file.mime);
}

export function isPdf(file) {
    return [
        'application/pdf',
        'application/x-pdf',
        'application/acrobat',
        'applications/vnd.pdf',
        'text/pdf',
        'text/x-pdf'
    ].includes(file.mime);
}

export function isAudio(file) {
    return [
        'audio/mpeg',
        'audio/wav',
        'audio/ogg',
        'audio/flac',
        'audio/aac',
        'audio/mp4',
        'audio/webm',
        'audio/x-m4a'
    ].includes(file.mime);
}
export function isVideo(file) {
    return [
        'video/mp4',
        'video/mpeg',
        'video/ogg',
        'video/webm',
        'video/quicktime',
        'video/x-msvideo',
        'video/x-ms-wmv'
    ].includes(file.mime);
}

export function isText(file) {
    return [
        'text/plain',
        'text/html',
        'text/css',
        'text/javascript',
        'application/json',
        'application/xml',
    ].includes(file.mime);
}
export function isZip(file) {
    return [
        'application/zip',
        'application/x-zip-compressed',
        'multipart/x-zip',
        'application/x-compress',
        'application/zip-compressed',
        'application/x-compressed',
        'application/x-7z-compressed',
        'application/x-rar-compressed',
        'application/x-tar',
        'application/gzip',
        'application/x-bzip2',
        'application/x-gzip',
        'application/x-xz',
    ].includes(file.mime);
}

export function isWord(file) {
    return [
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-word.document.macroEnabled.12',
        'application/vnd.ms-word.template.macroEnabled.12',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template',

    ].includes(file.mime);
}
export function isExcel(file) {
    return [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-excel.sheet.macroEnabled.12',
        'application/vnd.ms-excel.template.macroEnabled.12',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'application/vnd.ms-excel.addin.macroEnabled.12',

    ].includes(file.mime);
}

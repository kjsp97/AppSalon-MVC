import path from 'path'
import fs from 'fs'
import {glob} from 'glob'
import {src, dest, watch, series} from 'gulp'
import * as dartSass from 'sass'
import gulpSass from 'gulp-sass'
import terser from 'gulp-terser'
import cleanCSS from 'gulp-clean-css'
import sharp from 'sharp'


const sass = gulpSass(dartSass)

export function js(done) {
    src('src/js/*.js')
        .pipe(terser())
        .pipe(dest('public/build/js'));
    done()
}

export function css(done) {
    src('src/scss/app.scss', {sourcemaps: true})
    .pipe(sass().on('error', sass.logError))
    .pipe(cleanCSS({compatibility: 'ie8'}))
    .pipe(dest('public/build/css', {sourcemaps: '.'}))
    done()
}

//Codigo Nodejs para transformar a webp y jpg
export async function imagenes(done) {
    const srcDir = './src/img';
    const buildDir = 'public/build/img';
    const images =  await glob('./src/img/**/*{jpg,png}')

    images.forEach(file => {
        const relativePath = path.relative(srcDir, path.dirname(file));
        const outputSubDir = path.join(buildDir, relativePath);
        procesarImagenes(file, outputSubDir);
    });
    done();
}
//destino de transformar webp y jpg
function procesarImagenes(file, outputSubDir) {
    if (!fs.existsSync(outputSubDir)) {
        fs.mkdirSync(outputSubDir, { recursive: true })
    }
    const baseName = path.basename(file, path.extname(file))
    const extName = path.extname(file)

    if (extName.toLowerCase() === '.svg') {
        // If it's an SVG file, move it to the output directory
        const outputFile = path.join(outputSubDir, `${baseName}${extName}`);
        fs.copyFileSync(file, outputFile);
    } else {
    const outputFile = path.join(outputSubDir, `${baseName}${extName}`)
    const outputFileWebp = path.join(outputSubDir, `${baseName}.webp`)

    const options = { quality: 80 }
    sharp(file).jpeg(options).toFile(outputFile)
    sharp(file).webp(options).toFile(outputFileWebp)
    }
}


export function dev() {
    watch('src/scss/**/*.scss', css); 
    watch('src/js/**/*.js', js); 
    watch('src/img/**/*.{png,jpg}', imagenes); 
    
}

export default series(js, css, imagenes, dev);
export const build = series(js, css, imagenes);

const gulp       = require("gulp");
const sass       = require("gulp-sass")(require("sass"));
const postcss    = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const browserSync = require("browser-sync").create();

const paths = {
  scss: {
    src:  "scss/style.scss",
    dest: "css/",
    watch: "scss/**/*.scss",
  },
  html: {
    watch: "**/*.html",
  },
  js: {
    watch: "js/**/*.js",
  },
};

function compileSass() {
  return gulp
    .src(paths.scss.src, { sourcemaps: true })
    .pipe(sass({ outputStyle: "expanded" }).on("error", sass.logError))
    .pipe(postcss([autoprefixer()]))
    .pipe(gulp.dest(paths.scss.dest, { sourcemaps: "." }))
    .pipe(browserSync.stream());
}

function serve() {
  browserSync.init({
    server: { baseDir: "./" },
    notify: false,
    open: true,
  });
}

function watchFiles() {
  gulp.watch(paths.scss.watch, compileSass);
  gulp.watch([paths.html.watch, paths.js.watch]).on("change", browserSync.reload);
}

exports.default = gulp.series(
  compileSass,
  gulp.parallel(serve, watchFiles)
);

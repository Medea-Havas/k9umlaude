const config = require("./wpgulp.config.js");

// Load plugins
const gulp = require("gulp");
// CSS related plugins
const sass = require("gulp-sass")(require("sass"));
const minifycss = require("gulp-uglifycss");
const autoprefixer = require("gulp-autoprefixer");
const mmq = require("gulp-merge-media-queries");
const postcss = require("gulp-postcss");
const tailwindcss = require("tailwindcss");
// JS related plugins.
const concat = require("gulp-concat");
const uglify = require("gulp-uglify");
const babel = require("gulp-babel");
// Utility related plugins.
const rename = require("gulp-rename");
const lineec = require("gulp-line-ending-corrector");
const filter = require("gulp-filter");
const sourcemaps = require("gulp-sourcemaps");
const notify = require("gulp-notify");
const browserSync = require("browser-sync").create();
const remember = require("gulp-remember");
const plumber = require("gulp-plumber");
const beep = require("beepbeep");

// Custom Error Handler
const errorHandler = (r) => {
	notify.onError("\n\n❌💩🙈🙈🙈  ERROR: <%= error.message %>  🙈🙈🙈💩❌\n")(
		r
	);
	beep();
};

// Browser Sync
const browsersync = (done) => {
	browserSync.init({
		proxy: config.projectURL,
		open: config.browserAutoOpen,
		injectChanges: config.injectChanges,
		watchEvents: ["change", "add", "unlink", "addDir", "unlinkDir"],
	});
	done();
};

// Helper function to allow browser reload with Gulp 4.
const reload = (done) => {
	browserSync.reload();
	done();
};

// Styles - Compiles Sass, autoprefixes it and minifies CSS
gulp.task("styles", () => {
	return gulp
		.src(config.styleSRC, { allowEmpty: true })
		.pipe(plumber(errorHandler))
		.pipe(sourcemaps.init())
		.pipe(
			sass({
				errLogToConsole: config.errLogToConsole,
				outputStyle: config.outputStyle,
				precision: config.precision,
			})
		)
		.pipe(postcss([tailwindcss("tailwind.config.js"), require("autoprefixer")]))
		.on("error", sass.logError)
		.pipe(sourcemaps.write({ includeContent: false }))
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(autoprefixer(config.BROWSERS_LIST))
		.pipe(sourcemaps.write("./"))
		.pipe(lineec())
		.pipe(gulp.dest(config.styleDestination))
		.pipe(filter("**/*.css"))
		.pipe(mmq({ log: true }))
		.pipe(browserSync.stream())
		.pipe(rename({ suffix: ".min" }))
		.pipe(minifycss({ maxLineLen: 10 }))
		.pipe(lineec())
		.pipe(gulp.dest(config.styleDestination))
		.pipe(filter("**/*.css"))
		.pipe(browserSync.stream())
		.pipe(
			notify({
				message: "\n\n\t👍 STYLES COMPLETED 👍\n",
				onLast: true,
			})
		);
});

// Admin Styles - Compiles Sass, autoprefixes it and minifies CSS
gulp.task("adminStyles", () => {
	return gulp
		.src(config.adminStyleSRC, { allowEmpty: true })
		.pipe(plumber(errorHandler))
		.pipe(sourcemaps.init())
		.pipe(
			sass({
				errLogToConsole: config.errLogToConsole,
				outputStyle: config.adminOutputStyle,
				precision: config.precision,
			})
		)
		.pipe(postcss([tailwindcss("tailwind.config.js"), require("autoprefixer")]))
		.on("error", sass.logError)
		.pipe(sourcemaps.write({ includeContent: false }))
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(autoprefixer(config.BROWSERS_LIST))
		.pipe(sourcemaps.write("./"))
		.pipe(lineec())
		.pipe(gulp.dest(config.adminStyleDestination))
		.pipe(filter("**/*.css"))
		.pipe(mmq({ log: true }))
		.pipe(browserSync.stream())
		.pipe(rename({ suffix: ".min" }))
		.pipe(minifycss({ maxLineLen: 10 }))
		.pipe(lineec())
		.pipe(gulp.dest(config.adminStyleDestination))
		.pipe(filter("**/*.css"))
		.pipe(browserSync.stream())
		.pipe(
			notify({
				message: "\n\n\t👍 ADMIN STYLES COMPLETED 👍\n",
				onLast: true,
			})
		);
});

// Admin custom - Compiles Sass, autoprefixes it and minifies CSS
gulp.task("adminCustomStyles", () => {
	return gulp
		.src(config.adminStylesSRC, { allowEmpty: true })
		.pipe(plumber(errorHandler))
		.pipe(sourcemaps.init())
		.pipe(
			sass({
				errLogToConsole: config.errLogToConsole,
				outputStyle: config.adminOutputStyle,
				precision: config.precision,
			})
		)
		.pipe(postcss([tailwindcss("tailwind.config.js"), require("autoprefixer")]))
		.on("error", sass.logError)
		.pipe(sourcemaps.write({ includeContent: false }))
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(autoprefixer(config.BROWSERS_LIST))
		.pipe(sourcemaps.write("./"))
		.pipe(lineec())
		.pipe(gulp.dest(config.adminStylesDestination))
		.pipe(filter("**/*.css"))
		.pipe(mmq({ log: true }))
		.pipe(browserSync.stream())
		.pipe(rename({ suffix: ".min" }))
		.pipe(minifycss({ maxLineLen: 10 }))
		.pipe(lineec())
		.pipe(gulp.dest(config.adminStylesDestination))
		.pipe(filter("**/*.css"))
		.pipe(browserSync.stream())
		.pipe(
			notify({
				message: "\n\n\t👍 CUSTOM ADMIN STYLES COMPLETED 👍\n",
				onLast: true,
			})
		);
});

// Gutenberg Styles - Compiles Sass, autoprefixes it and minifies CSS
gulp.task("gutStyles", () => {
	return gulp
		.src(config.gutStyleSRC, { allowEmpty: true })
		.pipe(plumber(errorHandler))
		.pipe(sourcemaps.init())
		.pipe(postcss([tailwindcss("tailwind.config.js"), require("autoprefixer")]))
		.pipe(
			sass({
				errLogToConsole: config.errLogToConsole,
				outputStyle: config.outputStyle,
				precision: config.precision,
			})
		)
		.on("error", sass.logError)
		.pipe(sourcemaps.write({ includeContent: false }))
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(autoprefixer(config.BROWSERS_LIST))
		.pipe(sourcemaps.write("./"))
		.pipe(lineec())
		.pipe(gulp.dest(config.gutStyleDestination))
		.pipe(filter("**/*.css"))
		.pipe(mmq({ log: true }))
		.pipe(browserSync.stream())
		.pipe(rename({ suffix: ".min" }))
		.pipe(minifycss({ maxLineLen: 10 }))
		.pipe(lineec())
		.pipe(gulp.dest(config.gutStyleDestination))
		.pipe(filter("**/*.css"))
		.pipe(browserSync.stream())
		.pipe(
			notify({
				message: "\n\n\t👍 GUTENBERG STYLES COMPLETED 👍\n",
				onLast: true,
			})
		);
});

// Login Styles - Compiles Sass, autoprefixes it and minifies CSS
gulp.task("loginStyles", () => {
	return gulp
		.src(config.logStyleSRC, { allowEmpty: true })
		.pipe(plumber(errorHandler))
		.pipe(sourcemaps.init())
		.pipe(postcss([tailwindcss("tailwind.config.js"), require("autoprefixer")]))
		.pipe(
			sass({
				errLogToConsole: config.errLogToConsole,
				outputStyle: config.outputStyle,
				precision: config.precision,
			})
		)
		.on("error", sass.logError)
		.pipe(sourcemaps.write({ includeContent: false }))
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(autoprefixer(config.BROWSERS_LIST))
		.pipe(sourcemaps.write("./"))
		.pipe(lineec())
		.pipe(gulp.dest(config.logStyleDestination))
		.pipe(filter("**/*.css"))
		.pipe(mmq({ log: true }))
		.pipe(browserSync.stream())
		.pipe(rename({ suffix: ".min" }))
		.pipe(minifycss({ maxLineLen: 10 }))
		.pipe(lineec())
		.pipe(gulp.dest(config.logStyleDestination))
		.pipe(filter("**/*.css"))
		.pipe(browserSync.stream())
		.pipe(
			notify({
				message: "\n\n\t👍 LOGIN STYLES COMPLETED 👍\n",
				onLast: true,
			})
		);
});

// Vendor JS - Concatenates and uglifies vendor JS scripts
gulp.task("vendorsJS", () => {
	return gulp
		.src(config.jsVendorSRC, { since: gulp.lastRun("vendorsJS") })
		.pipe(plumber(errorHandler))
		.pipe(
			babel({
				presets: [
					[
						"@babel/preset-env",
						{
							targets: { browsers: config.BROWSERS_LIST },
						},
					],
				],
			})
		)
		.pipe(remember(config.jsVendorSRC))
		.pipe(concat(config.jsVendorFile + ".js"))
		.pipe(lineec())
		.pipe(gulp.dest(config.jsVendorDestination))
		.pipe(
			rename({
				basename: config.jsVendorFile,
				suffix: ".min",
			})
		)
		.pipe(uglify())
		.pipe(lineec())
		.pipe(gulp.dest(config.jsVendorDestination))
		.pipe(
			notify({
				message: "\n\n\t👍 VENDOR JS COMPLETED 👍\n",
				onLast: true,
			})
		);
});

// Custom JS - Concatenates and uglifies custom JS scripts
gulp.task("customJS", () => {
	return gulp
		.src(config.jsCustomSRC, { since: gulp.lastRun("customJS") })
		.pipe(plumber(errorHandler))
		.pipe(
			babel({
				presets: [
					[
						"@babel/preset-env",
						{
							targets: { browsers: config.BROWSERS_LIST },
						},
					],
				],
			})
		)
		.pipe(remember(config.jsCustomSRC))
		.pipe(concat(config.jsCustomFile + ".js"))
		.pipe(lineec())
		.pipe(gulp.dest(config.jsCustomDestination))
		.pipe(
			rename({
				basename: config.jsCustomFile,
				suffix: ".min",
			})
		)
		.pipe(uglify())
		.pipe(lineec())
		.pipe(gulp.dest(config.jsCustomDestination))
		.pipe(
			notify({
				message: "\n\n\t👍 CUSTOM JS COMPLETED 👍\n",
				onLast: true,
			})
		);
});

// Watch tasks - Watches for file changes and runs specific tasks
gulp.task(
	"default",
	gulp.parallel("styles", "vendorsJS", "customJS", browsersync, () => {
		gulp.watch(config.watchPhp, reload);
		gulp.watch(config.watchTwig, reload);
		gulp.watch(config.watchStyles, gulp.parallel("styles"));
		gulp.watch(config.watchAdminStyles, gulp.parallel("adminStyles"));
		gulp.watch(
			config.watchCustomAdminStyles,
			gulp.parallel("adminCustomStyles")
		);
		gulp.watch(config.watchGutStyles, gulp.parallel("gutStyles"));
		gulp.watch(config.watchLogStyles, gulp.parallel("loginStyles"));
		gulp.watch(config.watchJsVendor, gulp.series("vendorsJS", reload));
		gulp.watch(config.watchJsCustom, gulp.series("customJS", reload));
	})
);

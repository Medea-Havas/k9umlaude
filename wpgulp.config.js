const projectURL = "http://localhost/k9umlaude";
const productURL = "./";

const browserAutoOpen = true;
const injectChanges = false;
const errLogToConsole = true;
const precision = 10;
const BROWSERS_LIST = ["defaults"]; // https://github.com/ai/browserslist

const styleSRC = "./src/scss/styles.scss";
const styleDestination = "./assets/css/";
const outputStyle = "compressed"; // compact, compressed, nested or expanded

const adminStyleSRC = "./src/admin/colors.scss";
const adminStyleDestination = "./assets/css/";
const adminOutputStyle = "compressed"; // compact, compressed, nested or expanded

const gutStyleSRC = "./src/gutenberg/style-editor.scss";
const gutStyleDestination = "./assets/css/";
const gutOutputStyle = "compressed"; // compact, compressed, nested or expanded

const logStyleSRC = "./src/login/style-login.scss";
const logStyleDestination = "./assets/css/";
const logOutputStyle = "compressed"; // compact, compressed, nested or expanded

const jsVendorSRC = "./src/js/vendor/*.js";
const jsVendorDestination = "./assets/js/";
const jsVendorFile = "vendor";

const jsCustomSRC = "./src/js/custom/*.js";
const jsCustomDestination = "./assets/js/";
const jsCustomFile = "main";

const watchStyles = "./src/scss/**/*.scss";
const watchAdminStyles = "./src/admin/**/*.scss";
const watchGutStyles = "./src/gutenberg/**/*.scss";
const watchLogStyles = "./src/login/**/*.scss";
const watchJsVendor = "./src/js/vendor/*.js";
const watchJsCustom = "./src/js/custom/*.js";
const watchPhp = "./**/*.php";
const watchTwig = "./**/*.twig";

const zipName = "medea.zip";
const zipDestination = "./../"; // Default: Parent folder.
const zipIncludeGlob = ["./**/*"]; // Default: Include all files/folders in current directory.
// Default ignored files and folders for the zip file.
const zipIgnoreGlob = [
	"!./{node_modules,node_modules/**/*}",
	"!./.git",
	"!./.svn",
	"!./gulpfile.babel.js",
	"!./wpgulp.config.js",
	"!./.eslintrc.js",
	"!./.eslintignore",
	"!./.editorconfig",
	"!./phpcs.xml.dist",
	"!./vscode",
	"!./package.json",
	"!./package-lock.json",
	"!./assets/css/**/*",
	"!./assets/css",
	"!./assets/img/raw/**/*",
	"!./assets/img/raw",
	`!${styleSRC}`,
	`!${adminStyleSRC}`,
	`!${gutStyleSRC}`,
	`!${logStyleSRC}`,
	`!${jsCustomSRC}`,
	`!${jsVendorSRC}`,
];

module.exports = {
	projectURL,
	productURL,
	browserAutoOpen,
	injectChanges,
	styleSRC,
	adminStyleSRC,
	gutStyleSRC,
	logStyleSRC,
	styleDestination,
	adminStyleDestination,
	gutStyleDestination,
	logStyleDestination,
	logOutputStyle,
	outputStyle,
	adminOutputStyle,
	gutOutputStyle,
	errLogToConsole,
	precision,
	jsVendorSRC,
	jsVendorDestination,
	jsVendorFile,
	jsCustomSRC,
	jsCustomDestination,
	jsCustomFile,
	watchStyles,
	watchAdminStyles,
	watchGutStyles,
	watchLogStyles,
	watchJsVendor,
	watchJsCustom,
	watchPhp,
	watchTwig,
	zipName,
	zipDestination,
	zipIncludeGlob,
	zipIgnoreGlob,
	BROWSERS_LIST,
};

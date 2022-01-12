// Scale Major Second - 1.125
const text11 = "0.702rem";
const text12 = "0.79rem";
const text14 = "0.889rem";
const text16 = "1rem";
const text18 = "1.125rem";
const text20 = "1.266rem";
const text25 = "1.602rem";
const text28 = "1.802rem";
const text32 = "2.027rem";
const text36 = "2.281rem";

module.exports = {
	purge: {
		enabled: true,
		content: ["./*.php", "./**/*.php", "./*.twig", "./**/*.twig"],
	},
	theme: {
		colors: {
			limegreen: "#c7d02e",
			darkgreen: "#20464c",
			lightblue: "#108aa8",
			darkblue: "#004e57",
			gray: "#efefef",
			line: "#f4f4f4",
			white: "#fff",
			black: "#000",
			transparent: "transparent",
		},
		fontFamily: {
			sans: ["Oxygen", "sans-serif"],
		},
		fontSize: {
			xs: text11,
			sm: text12,
			"base-sm": text14,
			base: text16,
			lg: text18,
			xl: text20,
			"2xl": text25,
			"3xl": text28,
			"4xl": text32,
			"5xl": text36,
		},
		extend: {
			screens: {
				"3xl": "1600px",
				"4xl": "10px",
			},
			lineHeight: {
				title: "1.3",
			},
		},
	},
	variants: {},
	plugins: [require("@tailwindcss/line-clamp")],
};

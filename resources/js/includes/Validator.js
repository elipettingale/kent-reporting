export default class Validator {
    validate(rules, value) {
        for (let i = 0; i < rules.length; i++) {
            let error = this[rules[i]](value);

            if (error !== false) {
                return {
                    valid: false,
                    error: error,
                };
            }
        }

        return {
            valid: true,
        };
    }

    required(value) {
        if (!value) {
            return "This field is required.";
        }

        return false;
    }
}

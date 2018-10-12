# CHANGELOG

## v1.0.0 (08.08.2018)
- Create Initial Classes (Rut, Validator, ChainRutValidator)
- Tested Rut
- Tested SimpleRutValidator
- Tested Symfony Form Type

## v2.0.0 (12.10.2018)
This is a major version because api changes and class renaming took place. 
Also, all features were properly tested with CI/CD pipelines.

- Changed ChainRutValidator constructor signature. Now uses argument spreading.
- Added tests for ChainRutValidator
- SimpleRutValidator renamed to Module11RutValidator
- Now class Rut always validates itself with the SimpleRutValidator if no validator
is passed. This ensures object consistency.
- Added test coverage reports, code quality and CI testing
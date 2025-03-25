<?php return array (
  'pixel-app-type' => 'admin-panel-app',
  'pixel-app-package-route-registrars' => 
  array (
    0 => 'PixelApp\\Routes\\RouteRegistrarTypes\\AuthenticationRoutesRegistrars\\CompanyAuthenticationAPIRoutesRegistrar',
    1 => 'PixelApp\\Routes\\RouteRegistrarTypes\\AuthenticationRoutesRegistrars\\UserAuthenticationAPIRoutesRegistrar',
    2 => 'PixelApp\\Routes\\RouteRegistrarTypes\\SystemConfigurationRouteRegistrars\\DropdownListRouteRegistrars\\AreasRouteRegistrar',
    3 => 'PixelApp\\Routes\\RouteRegistrarTypes\\SystemConfigurationRouteRegistrars\\DropdownListRouteRegistrars\\BranchesRouteRegistrar',
    4 => 'PixelApp\\Routes\\RouteRegistrarTypes\\SystemConfigurationRouteRegistrars\\DropdownListRouteRegistrars\\CitiesRouteRegistrar',
    5 => 'PixelApp\\Routes\\RouteRegistrarTypes\\SystemConfigurationRouteRegistrars\\DropdownListRouteRegistrars\\CountriesRouteRegistrar',
    6 => 'PixelApp\\Routes\\RouteRegistrarTypes\\SystemConfigurationRouteRegistrars\\DropdownListRouteRegistrars\\DepartmentRouteRegistrar',
    7 => 'PixelApp\\Routes\\RouteRegistrarTypes\\SystemConfigurationRouteRegistrars\\RolesAndPermissionsRouteRegistrar',
    8 => 'PixelApp\\Routes\\RouteRegistrarTypes\\UserAccountRoutesRegistrars\\CompanyBranchesAPIRoutesRegistrar',
    9 => 'PixelApp\\Routes\\RouteRegistrarTypes\\UserAccountRoutesRegistrars\\CompanyProfileAPIRoutesRegistrar',
    10 => 'PixelApp\\Routes\\RouteRegistrarTypes\\UserAccountRoutesRegistrars\\CompanySettingsAPIRoutesRegistrar',
    11 => 'PixelApp\\Routes\\RouteRegistrarTypes\\UserAccountRoutesRegistrars\\UserProfileAPIRoutesRegistrar',
    12 => 'PixelApp\\Routes\\RouteRegistrarTypes\\UserAccountRoutesRegistrars\\UserSignatureAPIRoutesRegistrar',
    13 => 'PixelApp\\Routes\\RouteRegistrarTypes\\UsersManagementRoutesRegistrars\\SignUpUsersAPIRoutesRegistrar',
    14 => 'PixelApp\\Routes\\RouteRegistrarTypes\\UsersManagementRoutesRegistrars\\UsersAPIRoutesRegistrar',
  ),
  'pixel-macroable-extenders' => 
  array (
    0 => 'PixelApp\\PixelMacroableExtenders\\PixelBlueprintExtender',
    1 => 'PixelApp\\PixelMacroableExtenders\\PixelBuilderExtender',
    2 => 'PixelApp\\PixelMacroableExtenders\\PixelCarbonExtender',
    3 => 'PixelApp\\PixelMacroableExtenders\\PixelHasManyExtender',
    4 => 'PixelApp\\PixelMacroableExtenders\\PixelStrExtender',
    5 => 'PixelApp\\PixelMacroableExtenders\\PixelReponseExtender',
  ),
  'pixel-tenancy-service-provider-class' => 'PixelApp\\ServiceProviders\\RelatedPackagesServiceProviders\\TenancyServiceProvider',
) ;
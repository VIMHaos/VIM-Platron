# VIM-Platron 

VIM-Platron is a small Class for work with Platron (https://www.platron.pro/), API Docs https://client.platron.pro/apisettings/index.
Platron - a service for receiving payments, allowing payments in online stores using popular online payment tools.

## Initialisation Platron
```
require '/platron.class.php';
$platron = new VIMPlatron('Your login','token');
```

## Usage
(string) $method - Request method
(array) $params - Request data
```
$platron->sign($method,$params)->send();
```

Get Info about last request & response
```
print_r($platron->Request());
print_r($platron->Response());
```

## Examples
	
Get a list of available accounts [/account/list]
```
$platron->sign('/account/list')->send();
print_r($platron->Response());
```

Verify the creation of a signature [/test/check_sign]
```
$platron->sign('/test/check_sign')->send();
print_r($platron->Response());
```

Get a list of available accounts [/account/list]
```
$platron->sign('/account/list')->send();
print_r($platron->Response());
```

Create Transaction [/transaction/new]
```
$platron->sign('/transaction/new', [ 
	"ClientTransactionId"=>"abcd1234", // Client-side transaction ID
	"AccountId"=>"1", // Account identifier in the system Platron.pro
	"TypePaymentMethod"=>20, // Card - 10 | Phone - 20 | WM-wallet - 30 | Bank account - 40 | Yandex-wallet - 50 | Kiwi-wallet - 60
	"AccountNumber"=>"79093222111", // Account number. This can be a mobile phone number, card number, bank account, etc. depending on the payment method.
	"Amount"=>100.03,
	"Currency"=>"RUB", // RUB|USD|EUR
])->send();
print_r($platron->Response());
```

Checking the status of the transaction [/transaction/status]
```
$platron->sign('/transaction/status',[
	"ClientTransactionId"=>"abcd1234"
])->send();
print_r($platron->Response());
```

Cancel a transaction [/transaction/cancel]
```
$platron->sign('/transaction/cancel',[
	"ClientTransactionId"=>"abcd1234"
])->send();
print_r($platron->Response());
```

Confirmation of transaction [/transaction/confirm]
```
$platron->sign('/transaction/confirm',[
	"ClientTransactionId"=>"abcd1234"
])->send();
print_r($platron->Response());
```

Open dispute on transaction [/transaction/open_dispute]
```
$platron->sign('/transaction/open_dispute',[
	"ClientTransactionId"=>"abcd1234"
])->send();
print_r($platron->Response());
```

Receiving information about the payee [/user/info]
```
$platron->sign('/user/info',[
	"UserInfoIdentity"=>20, // Types of payee filter: ByCard - 10 | ByMobile - 20 | ByWmPurse - 30 | ByBankAccount - 40 | ByYandexPurse - 50 | ByQiwiPurse - 60
	"UserId"=>"79050000001"
])->send();
print_r($platron->Response());
```

To receive the financial report on the account for the period [/report/financial]
```
$platron->sign('/report/financial',[
	"AccountId"=>"1",
	"StartDate"=>"09.11.2016 01:00:00",
	"EndDate"=>"09.11.2016 02:00:00",
])->send();
print_r($platron->Response());
```

Get a list of transactions for the period [/report/transaction_list]
```
$platron->sign('/report/transaction_list',[
	"AccountId"=>"1",
	"StartDate"=>"09.11.2016 01:00:00",
	"EndDate"=>"09.11.2016 02:00:00",
])->send();
print_r($platron->Response());
```
# ezerphp
Automatically exported from code.google.com/p/ezerphp

PHP Business Process Management and Automation
The Ezer project attempts to offer PHP developrs the abilities of BPM, business process management and process workflow automation.

So far, we can offer the following functionalities.

Done:
Configuration management - parses any xml file into php class object.
System process management - fork your tasks into several working processes.
Sockets management - enables sockets client to connect the server in order to enable remote command and control, or scalability between few servers.
Business process management.
XML (BPEL like) process and case persistence.
DB (mySql over Propel ORM) process and case persistence.
Support complex variable types.
Asynchronous activities.
Supported step types:
PHP
Assign
Supported flow types:
Sequence
Scope
If
Else
ElseIf
Flow (concurrent execution of few tasks in the same process).
Foreach - parallel or serial.
Currently process design user interface is in the oven.

TODOs:
Support more flow types:
While
RepeatUntil
Switch
Support more step types:
Empty
Wait
Terminate
Throw
Rethrow
Support XML data type.
Add load balancing according to the following resources
DB
Network
File system
CPU
Support BPEL.
WSDL
More step types:
Invoke
Pick
Receive
Reply
Compensate
CompensateScope
Validate
OpaqueActivity
Add jquery proccess designer.
Add control panel (maybe flex or jquery).
Add support for BAM systems.
Looked like a lot of work, will be happy for some help.

eip_diving
==========

Elastic IP (EIP) Diving is one of the theoretical attacks demonstrated in my Geekfest Presentation: "Hacking Amazon: Are we any more or less secure in the cloud." (Pictured Below)

- Author: @bw_z (b@delonge.com.au)
- Copyright (c) @bw_z (See included license for terms)

![alt tag](https://raw.github.com/bw-z/eip_diving/master/photo.jpg)

EIP Diving attempts to take advantage of the process whereby Elastic IP addresses are allocated and assigned to accounts. As an EIP can be allocated, released imediately and then assigned to another users instance this attack could theoretically allow an attacker to identify many instances which are new and not yet hardened. 

#### BEWARE
Use of this script would be likely in violation of Amazon's TOS and you should check local laws before its use. While the range of IPs/Ports being scanned by the tool is selective, it could be classified as a Port Scanning or Ping Sweep tool.

